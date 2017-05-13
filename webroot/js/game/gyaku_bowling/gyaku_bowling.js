phina.globalize();

var SCREEN_WIDTH   = 800;
var SCREEN_HEIGHT   = 490;

var SCREEN_CENTER_X = SCREEN_WIDTH/2;
var SCREEN_CENTER_Y = SCREEN_HEIGHT/2;

var gravity = new b2Vec2(0, 9.8);
var WORLD = new b2World(gravity, true);

var WORLD_SCALE = 20;
var WORLD_WIDTH = 40;
var WORLD_HEIGHT = 25;

//グループ作成
var PINGROUP;
var GROUNDBOWLGROUP;

var PINCOUNT;

var GAMEFLG;

//ゲーム画面のラベル
var UI_DATA = {
    main: { // MainScene用ラベル
        children: {
            //スコア
            'score_lavel' : {
                className: "Label",
                fontSize: 20,
                fillStyle: "Black",
                x: 130,
                y: 145,
            },
            'pincount_lavel' : {
                className: "Label",
                x: 75,
                y: 70,
                fillStyle: "Black",
                text: " ",
                fontSize: 20,
            },
        }
    }
};

// メイン
phina.main(function() {
  var app = GameApp({
    title: '',
    assets: ASSETS,
    width :  SCREEN_WIDTH,
    height : SCREEN_HEIGHT
  });
  var locked = true;
  var f = function(e){
    if(locked){
      var s = phina.asset.Sound();
      s.loadFromBuffer();
      s.play();
      s.volume=0;
      Sound.context = new AudioContext();
      s.stop();

      var s = phina.asset.Sound();
      s.loadFromBuffer();
      s.play();
      s.stop();

      locked=false;
      app.domElement.removeEventListener('touchend',f);
    }
  };
  app.domElement.addEventListener('touchend',f);
  app.run();
});

//タイトル画面----------------------------------------------------------------------
phina.define("TitleScene", {
    superClass : "phina.game.TitleScene",
 
    init : function() {
        this.superInit({
            title :  "",
            width :  SCREEN_WIDTH,
            height : SCREEN_HEIGHT
        });

        this.title = phina.display.Sprite("title", SCREEN_WIDTH, SCREEN_HEIGHT).addChildTo(this);
        this.title.position.set(SCREEN_WIDTH/2, SCREEN_HEIGHT/2);

        // 画面(シーンの描画箇所)をタッチした時の動作
        this.addEventListener("pointingend", function(e) {
            // シーンの遷移
            e.app.replaceScene(MainScene());
        });
    },
});

/*---------------------------------------------------------------
                        ゲームシーン            
-----------------------------------------------------------------*/
phina.define('MainScene', {
  superClass: 'CanvasScene',

    init: function() {
        // 親の初期化
        this.superInit({
            title :  "",
            width :  SCREEN_WIDTH,
            height : SCREEN_HEIGHT
        });

        //PINCOUNT = 30;
        PINCOUNT = 300;
        this.score = 0;
        SCORE = 0;
        GAMEFLG = 0; //1でゲームオーバ

        //背景画像の設定   'ちなみに　画像は最初に生成したヤツが一番奥にくる　画像のグループも同様　スプライトのグループは背景画像のあとに書くこと'
        var back = phina.display.Sprite("back", SCREEN_WIDTH, SCREEN_HEIGHT).addChildTo(this);
        back.position.set(SCREEN_WIDTH/2, SCREEN_HEIGHT/2);

        //ラベルの登録
        this.fromJSON(UI_DATA.main);

        //タイマー設定
        this.timer = 1;
        //ゲームレベル設定
        this.Level = 1;
        //スプライトグループ登録
        PINGROUP = phina.display.CanvasElement().addChildTo(this);
        GROUNDBOWLGROUP = phina.display.CanvasElement().addChildTo(this);

        // 重力と物理世界の設定
        var gravity = new b2Vec2(0, 9.8);
        this.world = new b2World(gravity, true);

        //床の作成
        var ground = createbox(WORLD,0,0,WORLD_HEIGHT,WORLD_WIDTH,1);

        //主人公の作成
        this.player = Player().addChildTo(this);

        this.enemy_create();

        var initBowlCount = 2;
        for (var i = 0; i < initBowlCount; i++) {
            var GroundBowl = GroundBowl_create(this.Level).addChildTo(GROUNDBOWLGROUP);
        }
    },

    update: function(app) {
        var timeStep = 1 / 30;
        var velocityIterations = 1;
        var positionIterations = 1;
        var p = app.pointer;

        //タッチされたら
        if(app.pointer.getPointingStart() == true){

            if(PINCOUNT > 0){
                //投げるアニメーション
                this.player.ss.gotoAndPlay("nage");
                //タッチされた場所に向けてピンを飛ばす
                var pin = pin_create(WORLD, p.x / 20, p.y / 20).addChildTo(PINGROUP);
                PINCOUNT--;

                var SE1 = AssetManager.get('sound', 'sore');
                SE1.play();

                if(PINCOUNT == 0){
                    this.player.ss.gotoAndPlay("owata");
                }
            }
        }

        //ボールを出現させる
        this.enemy_create();

        if(this.timer % 300 == 0){
            this.Level += 1;
        }

        // 物理空間の更新
        WORLD.Step(timeStep,velocityIterations,positionIterations);

        this.timer++;

        //画面の更新
        this.pincount_lavel.text = PINCOUNT;
        this.score_lavel.text = SCORE;

        if(GAMEFLG == 1){
            this.GAMEOVER(app);
        }
    },

    enemy_create: function(){
        //GroundBowl生成
        //if(this.timer % 90 == 0){
        var groundBowlCreateFPS = 80;
        var createBowlCount = 2;

        if(this.Level == 9) {
            groundBowlCreateFPS = 70;
        } else if(this.Level  == 10) {
            groundBowlCreateFPS = 60;
        } else if(this.Level  == 11){
            groundBowlCreateFPS = 50;
        } else if(this.Level  == 12){
            groundBowlCreateFPS = 40;
        } else if(this.Level  == 13){
            groundBowlCreateFPS = 35;
        } else if(this.Level  == 14){
            groundBowlCreateFPS = 30;
        } else if(this.Level >= 15){
            groundBowlCreateFPS = 20;
        }

        if(this.Level == 2) {
            createBowlCount = 3;
        } else if(this.Level  == 3) {
            createBowlCount = 3;
        } else if(this.Level  == 4){
            createBowlCount = 3;
        } else if(this.Level  == 5){
            createBowlCount = 4;
        } else if(this.Level  == 6){
            createBowlCount = 4;
        } else if(this.Level  == 7){
            createBowlCount = 4;
        } else if(this.Level >= 8){
            createBowlCount = 5;
        }

        if(this.timer % groundBowlCreateFPS == 0){
            for (var i = 0; i < createBowlCount; i++) {
                var GroundBowl = GroundBowl_create(this.Level).addChildTo(GROUNDBOWLGROUP);
            }
        }

        //FlyBowlの生成
        /*
        if(this.timer % 120 == 0　&& this.Level > 2){
            var FlyBowl = FlyBowl_create(this.Level).addChildTo(this);
        }
        */
    },

    //ゲームオーバー処理　box2dオブジェクトは勝手に消えないので、ちゃんと消す
    GAMEOVER: function(app){

        var yc = PINGROUP.children;
        yc.each(function(pin) {
                WORLD.DestroyBody(pin.pin);
        });

        var ec = GROUNDBOWLGROUP.children;
        ec.each(function(GroundBowl) {
                WORLD.DestroyBody(GroundBowl.GroundBowl);
        });
        
        this.nextLabel = 'result';
        this.exit({
          score: SCORE,  
        });
    },
});

/*------------------------------------------------*/
var pin_create = phina.createClass({
    superClass: phina.display.Sprite,
    init: function(world,x,y) {
        this.superInit("pin");

        //Box2d用パラメータ
        this.Box2d_x = 4;
        this.Box2d_y = WORLD_HEIGHT - 4;
        this.Box2d_width = 1.2;
        this.Box2d_height = 0.3;
        this.Box2d_type = 1;    //静的か動的か　0:静的　１：動的

        this.Scale = 20;

        this.timer = 0;

        this.width = this.Box2d_width * (this.Scale * 2);
        this.height = this.Box2d_height * (this.Scale * 2);

        this.soundFlag = 0;

        //Box2dオブジェクトを作成する
        this.pin = createbox(WORLD,this.Box2d_type,this.Box2d_x,this.Box2d_y,this.Box2d_width,this.Box2d_height,1);

        //ピンの飛ぶ方向と力
        var vector_x = (x - this.Box2d_x);
        var vector_y = (y - this.Box2d_y) -5;

        this.pin.SetLinearVelocity(new b2Vec2(vector_x, vector_y));
    },
    
    update: function(app) {
        //Box2d世界から位置を取得する
        this.x = this.pin.GetPosition().x * this.Scale;
        this.y = this.pin.GetPosition().y * this.Scale;

        //Box2d世界から角度を取得する（ラジアンから度に直す）
        this.rotation = this.pin.GetAngle() * 180 / Math.PI;
        if(this.timer > 50　&& this.y > SCREEN_HEIGHT - 30){
            WORLD.DestroyBody(this.pin);
        }
        this.timer++;
    },
    
});

/*------------------------------------------------*/
phina.define("GroundBowl_create", {
    superClass: "phina.display.Sprite",

    init: function(Level) {
        var bowlDiv = rand(2);
        if (bowlDiv == 1) {
            this.superInit("FlyBowl");
        } else {
            this.superInit("GroundBowl");
        }
        

        this.Size;
        this.Speed;
        this.Start_y;

        this.GroundBowl_Level(Level);

        //Box2d用パラメータ
        this.Box2d_x = WORLD_WIDTH;
        this.Box2d_y = WORLD_HEIGHT - this.Start_y - this.Size;
        this.Box2d_width = this.Size;
        this.Box2d_height = this.Size;
        this.Box2d_type = 1;    //静的か動的か　0:静的　１：動的

        this.Scale = 20;

        this.timer =0;

        this.width = this.Box2d_width * (this.Scale * 2);
        this.height = this.Box2d_height * (this.Scale * 2);

        //Box2dオブジェクトを作成する
        this.GroundBowl = createbox(WORLD,this.Box2d_type,this.Box2d_x,this.Box2d_y,this.Box2d_width,this.Box2d_height);
        this.GroundBowl.SetLinearVelocity(new b2Vec2(-this.Speed,-3));
    },

    //レベリング
    GroundBowl_Level: function(Level){

        //サイズ
        this.Size = 2;

/*
        if(Level > 3){
            this.Size = 2 * rand(2);
        }

        if(Level > 6){
            this.Size = 2 * rand(3);
        }

        if(Level > 9){
            this.Size = 2 * rand(4);
        }

        if(Level > 15){
            this.Size = 2 * rand(5);
        }
*/

        //スピード
        //this.Speed = 5;

        //出現する高さ
        //var i = 3 * Level;
        //if(i > 15){
        //    i = 15;
        //}
        //this.Start_y = rand(i) + this.Size;

        this.Speed = 5;
        this.Start_y = rand(15) + this.Size;
    },

    update: function(app) {
        this.x = this.GroundBowl.GetPosition().x * this.Scale;
        this.y = this.GroundBowl.GetPosition().y * this.Scale;

        this.rotation = this.GroundBowl.GetAngle() * 180 / Math.PI;

        var self = this;
        var pingroupChildren = PINGROUP.children;
        pingroupChildren.each(function(pin) {
            if (self.hitTestElement(pin)) {
                //sound
                if (pin.soundFlag == 0) {
                    pin.soundFlag = 1;
                    var SE1 = AssetManager.get('sound', 'bowling-pin2');
                    SE1.play();
                }
            };
        });

        //下に落ちたら消える
        if(this.y > SCREEN_HEIGHT){

            PINCOUNT+= 1 * this.Size -1;
            SCORE+= 1;

            WORLD.DestroyBody(this.GroundBowl);
            this.remove();

        }

        if(this.x < 0){
            GAMEFLG = 1;
        }
    },

});

/*------------------------------------------------*/
phina.define("FlyBowl_create", {
    superClass: "phina.display.Sprite",

    init: function(Level) {
        this.superInit("FlyBowl");

        this.x = SCREEN_WIDTH;
        this.y = rand(SCREEN_HEIGHT - 180);

        this.width = 70;
        this.height = 70;

        this.speed = 3 + (1 + Level / 10);

        this.rakka = 0;
    },

    update: function(app) {
        this.x -= this.speed;
        this.y += this.rakka;
        this.rotation += this.rakka * 2;

        var self = this;
        var pingroupChildren = PINGROUP.children;
        pingroupChildren.each(function(pin) {
            if (self.hitTestElement(pin)) {
                self.speed = -10;
                self.rakka = 10;
                //sound
                if (pin.soundFlag == 0) {
                    pin.soundFlag = 1;
                    var SE1 = AssetManager.get('sound', 'bowling-pin2');
                    SE1.play();
                }
            };
        });

        if(this.y > SCREEN_HEIGHT * 2){

            PINCOUNT+= 1;
            SCORE+= 1;

            this.remove();
        }

        if(this.x < 0){
            GAMEFLG = 1;
        }
    },
});

/*------------------------------------------------*/
phina.define("Player", {
    superClass: "phina.display.Sprite",

    init: function () {
        this.superInit("player", 50, 50);
        this.setScale(1/4);
        var ss = phina.accessory.FrameAnimation('playerSS')
        ss.attachTo(this);
        this.ss = ss;
        this.ss.gotoAndPlay("tame");

        this.x = 50;
        this.y = 450;
    },

    update: function(app) {

    },

});

/*---------------------------------------------------------------                        
                        createbox(World,type,位置xy,幅,高さ)      
                        ・box2dオブジェクトの作成
                        ・type = 0:静的オブジェクト　1:動的オブジェクト
-----------------------------------------------------------------*/
function createbox(world,type,x,y,width,height,option){
    var boxFixDef,boxShape,boxBodyDef,b2body;

    //フィクスチャーの定義を生成
    boxFixDef = new b2FixtureDef();
    boxFixDef.density = 1.0;
    boxFixDef.friction = 1;
    boxFixDef.restitution = 1;

    if(option == 1){
        boxFixDef.density = 10.0;
        boxFixDef.friction = 0.5;
        boxFixDef.restitution = 0.2;
    }

    //フィクスチャーの形
    boxShape = new b2PolygonShape();
    boxShape.SetAsBox(width, height);  
    boxFixDef.shape = boxShape;

    //ボディを定義
    boxBodyDef = new b2BodyDef();
    boxBodyDef.position.Set(x, y);
    //動的か静的か
    if(type == 0){
        boxBodyDef.type = b2Body.b2_staticBody;
    }
    else{
        boxBodyDef.type = b2Body.b2_dynamicBody;
    }

    b2body = world.CreateBody( boxBodyDef );//ボディをworldに生成し…
    b2body.CreateFixture( boxFixDef );//フィクスチャーを追加する

    return b2body;
}

function rand(n){
    return Math.floor(Math.random() * (n)) + 1;
}
