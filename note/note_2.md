# Slim 3 Note2 0903

## PSR-4
### composer.json
    "autoload": {
    	"psr-4": {
    		"App\\": "app"
    	}
    }
### 更新autoload
    $ composer dump-autoload -o

## Controller

    namespace App\Controllers;  

    class HomeController
    {
        public function index($request, $response)
        {
            var_dump($request->getParam('n'));// 取得get函數的方法
            return 'home controller';
        }
    }

$request->getParam('get名稱')