phina.globalize();

var SCREEN_WIDTH   = 800;
var SCREEN_HEIGHT   = 490;

var SCREEN_CENTER_X = SCREEN_WIDTH/2;
var SCREEN_CENTER_Y = SCREEN_HEIGHT/2;

var gravity = new b2Vec2(0, 0);
var WORLD = new b2World(gravity, true);

var WORLD_SCALE = 20;
var WORLD_WIDTH = 40;
var WORLD_HEIGHT = 25;

//グループ作成
var BALLGROUP;
var KYUGROUP;

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
        BALLGROUP = phina.display.CanvasElement().addChildTo(this);
        KYUGROUP = phina.display.CanvasElement().addChildTo(this);

        // 重力と物理世界の設定
        var gravity = new b2Vec2(0, 9.8);
        this.world = new b2World(gravity, true);

        //かべの作成
        var floor = createbox(WORLD, 0, 0, WORLD_HEIGHT - 0.5, WORLD_WIDTH, 1);
        var top = createbox(WORLD, 0, 0, -0.2, WORLD_WIDTH, 1);

        this.enemy_create();

        var initBowlCount = 2;
        for (var i = 0; i < initBowlCount; i++) {
            var kyu = kyu_create(this.Level).addChildTo(KYUGROUP);
        }
    },

    update: function(app) {
        var timeStep = 1 / 30;
        var velocityIterations = 1;
        var positionIterations = 1;
        var p = app.pointer;

        //タッチされたら
        if(app.pointer.getPointingStart() == true){

            //タッチされた場所に向けてピンを飛ばす
            var ball = ball_create(WORLD, p.x / 30, p.y / 20).addChildTo(BALLGROUP);

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
        this.score_lavel.text = SCORE;

        if(GAMEFLG == 1){
            this.GAMEOVER(app);
        }
    },

    enemy_create: function(){
        var kyuCreateFPS = 80;
        var createKyuCount = 2;

        if(this.Level == 9) {
            kyuCreateFPS = 70;
        } else if(this.Level  == 10) {
            kyuCreateFPS = 60;
        } else if(this.Level  == 11){
            kyuCreateFPS = 50;
        } else if(this.Level  == 12){
            kyuCreateFPS = 40;
        } else if(this.Level  == 13){
            kyuCreateFPS = 35;
        } else if(this.Level  == 14){
            kyuCreateFPS = 30;
        } else if(this.Level >= 15){
            kyuCreateFPS = 20;
        }

        if(this.Level == 2) {
            createKyuCount = 3;
        } else if(this.Level  == 3) {
            createKyuCount = 3;
        } else if(this.Level  == 4){
            createKyuCount = 3;
        } else if(this.Level  == 5){
            createKyuCount = 4;
        } else if(this.Level  == 6){
            createKyuCount = 4;
        } else if(this.Level  == 7){
            createKyuCount = 4;
        } else if(this.Level >= 8){
            createKyuCount = 5;
        }
        if (SCORE > 200) {
            createKyuCount = createKyuCount + 1;
        } else if (SCORE > 300) {
            createKyuCount = createKyuCount + 2;
        } else if (SCORE > 400) {
            createKyuCount = createKyuCount + 3;
        } else if (SCORE > 500) {
            createKyuCount = createKyuCount + 4;
        }
        if(this.timer % kyuCreateFPS == 0){
            for (var i = 0; i < createKyuCount; i++) {
                var kyu = kyu_create(this.Level).addChildTo(KYUGROUP);
            }
        }
    },

    //ゲームオーバー処理　box2dオブジェクトは勝手に消えないので、ちゃんと消す
    GAMEOVER: function(app){

        var ballChildren = BALLGROUP.children;
        ballChildren.each(function(ball) {
                WORLD.DestroyBody(ball.ball);
        });

        var ec = KYUGROUP.children;
        ec.each(function(kyu) {
                WORLD.DestroyBody(kyu.kyu);
        });
        
        this.nextLabel = 'result';
        this.exit({
          score: SCORE,  
        });
    },
});

/*------------------------------------------------*/
var ball_create = phina.createClass({
    superClass: phina.display.Sprite,
    init: function(world,x,y) {
        var ballDiv = rand(16);
        if (ballDiv == 1) {
            this.superInit("ball01");
        } else if(ballDiv  == 2) {
            this.superInit("ball02");
        } else if(ballDiv  == 3) {
            this.superInit("ball03");
        } else if(ballDiv  == 4) {
            this.superInit("ball04");
        } else if(ballDiv  == 5) {
            this.superInit("ball05");
        } else if(ballDiv  == 6) {
            this.superInit("ball06");
        } else if(ballDiv  == 7) {
            this.superInit("ball07");
        } else if(ballDiv  == 8) {
            this.superInit("ball08");
        } else if(ballDiv  == 9) {
            this.superInit("ball09");
        } else if(ballDiv  == 10) {
            this.superInit("ball10");
        } else if(ballDiv  == 11) {
            this.superInit("ball11");
        } else if(ballDiv  == 12) {
            this.superInit("ball12");
        } else if(ballDiv  == 13) {
            this.superInit("ball13");
        } else if(ballDiv  == 14) {
            this.superInit("ball14");
        } else if(ballDiv  == 15) {
            this.superInit("ball15");
        } else {
            this.superInit("ball_white");
        }
        
        //Box2d用パラメータ
        this.Box2d_x = 0;
        this.Box2d_y = y;
        this.Box2d_width = 1.5;
        this.Box2d_height = 1.5;
        this.Box2d_type = 1;    //静的か動的か　0:静的　１：動的

        this.Scale = 20;

        this.timer = 0;

        this.width = this.Box2d_width * (this.Scale * 2);
        this.height = this.Box2d_height * (this.Scale * 2);

        this.soundFlag = 0;

        //Box2dオブジェクトを作成する
        this.ball = createball(WORLD,this.Box2d_type,this.Box2d_x,this.Box2d_y,this.Box2d_width,this.Box2d_height,1);

        //飛ぶ方向と力
        var vector_x = (x - this.Box2d_x) * 1.8;
        var vector_y = (y - this.Box2d_y) * 1.8;

        this.ball.SetLinearVelocity(new b2Vec2(vector_x, vector_y));
    },
    
    update: function(app) {
        //Box2d世界から位置を取得する
        this.x = this.ball.GetPosition().x * this.Scale;
        this.y = this.ball.GetPosition().y * this.Scale;

        //Box2d世界から角度を取得する（ラジアンから度に直す）
        this.rotation = this.ball.GetAngle() * 180 / Math.PI;
        if(this.timer > 50 && this.y > SCREEN_HEIGHT - 30){
            WORLD.DestroyBody(this.ball);
            this.remove;
        }
        if(this.timer > 50 && this.y < 30){
            WORLD.DestroyBody(this.ball);
            this.remove;
        }
        this.timer++;
    },
    
});

/*------------------------------------------------*/
phina.define("kyu_create", {
    superClass: "phina.display.Sprite",

    init: function(Level) {
        this.superInit("kyu");

        this.Speed;
        this.Start_y;
        this.Speed = 6;
        this.Start_y = 2 + rand(13);

        //Box2d用パラメータ
        this.Box2d_x = WORLD_WIDTH + 2;
        this.Box2d_y = WORLD_HEIGHT - this.Start_y;
        //this.Box2d_width = this.Size;
        //this.Box2d_height = this.Size;
        this.Box2d_width = 5.5;
        this.Box2d_height = 0.25;

        this.Box2d_type = 1;    //静的か動的か　0:静的　１：動的

        this.Scale = 20;

        this.timer =0;

        this.width = this.Box2d_width * (this.Scale * 2);
        this.height = this.Box2d_height * (this.Scale * 2);

        //Box2dオブジェクトを作成する
        this.kyu = createKyubox(WORLD,this.Box2d_type,this.Box2d_x,this.Box2d_y,this.Box2d_width,this.Box2d_height);
        var vy = ( Math.random() * ( ( 4 + 1 ) - -4 ) ) -4;
        this.kyu.SetLinearVelocity(new b2Vec2(-this.Speed, vy));
    },

    update: function(app) {
        this.x = this.kyu.GetPosition().x * this.Scale;
        this.y = this.kyu.GetPosition().y * this.Scale;

        this.rotation = this.kyu.GetAngle() * 180 / Math.PI;

        var self = this;
        var ballgroupChildren = BALLGROUP.children;
        ballgroupChildren.each(function(ball) {
            if (self.hitTestElement(ball)) {
                //sound
                if (ball.soundFlag == 0) {
                    ball.soundFlag = 1;
                    var SE1 = AssetManager.get('sound', 'bill_break');
                    SE1.play();
                }
            };
        });

        //おいやったら消える
        if(this.x > SCREEN_WIDTH + 36){

            SCORE+= 1;

            WORLD.DestroyBody(this.kyu);
            this.remove();

        }

        if(this.x < 0){
            GAMEFLG = 1;
        }
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

function createball(world,type,x,y,width,height,option){
    var boxFixDef,boxShape,boxBodyDef,b2body;

    //フィクスチャーの定義を生成
    boxFixDef = new b2FixtureDef();
    boxFixDef.density = 0.8;
    boxFixDef.friction = 1;
    boxFixDef.restitution = 1;

    if(option == 1){
        boxFixDef.density = 10.0;
        boxFixDef.friction = 0.5;
        boxFixDef.restitution = 0.2;
    }
    boxShape = new b2CircleShape(
       width //radius
    );
    //フィクスチャーの形
  //  boxShape = new b2PolygonShape();
  //  boxShape.SetAsBox(width, height);
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

function createKyubox(world,type,x,y,width,height,option){
    var boxFixDef,boxShape,boxBodyDef,b2body;

    //フィクスチャーの定義を生成
    boxFixDef = new b2FixtureDef();
    boxFixDef.density = 4.0;
    boxFixDef.friction = 1.0;
    boxFixDef.restitution = 1;

    //フィクスチャーの形
    boxShape = new b2PolygonShape();
    boxShape.SetAsBox(width, height);
    boxFixDef.shape = boxShape;

    //ボディを定義
    boxBodyDef = new b2BodyDef();
    boxBodyDef.position.Set(x, y);

    boxBodyDef.type = b2Body.b2_dynamicBody;

    b2body = world.CreateBody( boxBodyDef );//ボディをworldに生成し…
    b2body.CreateFixture( boxFixDef );//フィクスチャーを追加する

    return b2body;
}

function rand(n){
    return Math.floor(Math.random() * (n)) + 1;
}
