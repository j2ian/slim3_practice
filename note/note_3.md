# Slim 3 Note3 0914
## Using Eloquent

## install
    composer require illuminate/database

## setup:bootstrap/app.php

    $capsule = new Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    // add Illuminate package
    $container['db'] = function ($container) use ($capsule){
        return $capsule;
    };

## 查詢範例
    $user = $this->db->table('users')->find(1);

    var_dump($user);//整筆資料
    var_dump($user->email);//只取出email欄位

## with model
    $user = User::find(1);
    $user = User::where('email','jack@rr.com')->first();

    User::create([
        'email'=>'test@test.com',
        'name'=>'test',
        'password'=>'123'
    ]);

## 其他筆記

getParam():取得參數
https://www.slimframework.com/docs/v3/objects/request.html#request-parameter

setName():https://www.slimframework.com/docs/v3/objects/router.html#route-names