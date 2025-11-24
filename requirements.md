## 指示
swaggerのuiにてテストを行っています。
/articlesのPOSTメソッド(storeアクション)についてのテストを行っています。
以下、valueです。
```
{
  "title": "Article Title",
  "content": "This is the content of the article"
}
```

以下、実行curlです。
```
curl -X 'POST' \
  'http://localhost/api/articles' \
  -H 'accept: application/json' \
  -H 'Authorization: Bearer 6|42mYwLZIYvsQZoVXhkA6f8khOg0EM56UjS3h9tObbc1d1693' \
  -H 'Content-Type: application/json' \
  -d '{
  "title": "Article Title",
  "content": "This is the content of the article"
}'
```

これを実行すると、500 Error:Internal Server Errorが出力されます。
以下、出力されたログです。
```
{
  "message": "App\\Models\\User::articles(): Return value must be of type Illuminate\\Database\\Eloquent\\HasMany, Illuminate\\Database\\Eloquent\\Relations\\HasMany returned",
  "exception": "TypeError",
  "file": "/var/www/html/app/Models/User.php",
  "line": 52,
  "trace": [
    {
      "file": "/var/www/html/app/Http/Controllers/Api/ArticleController.php",
      "line": 31,
      "function": "articles",
      "class": "App\\Models\\User",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php",
      "line": 46,
      "function": "store",
      "class": "App\\Http\\Controllers\\Api\\ArticleController",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Route.php",
      "line": 264,
      "function": "dispatch",
      "class": "Illuminate\\Routing\\ControllerDispatcher",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Route.php",
      "line": 210,
      "function": "runController",
      "class": "Illuminate\\Routing\\Route",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php",
      "line": 808,
      "function": "run",
      "class": "Illuminate\\Routing\\Route",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
      "line": 144,
      "function": "Illuminate\\Routing\\{closure}",
      "class": "Illuminate\\Routing\\Router",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php",
      "line": 51,
      "function": "Illuminate\\Pipeline\\{closure}",
      "class": "Illuminate\\Pipeline\\Pipeline",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
      "line": 183,
      "function": "handle",
      "class": "Illuminate\\Routing\\Middleware\\SubstituteBindings",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Auth/Middleware/Authenticate.php",
      "line": 64,
      "function": "Illuminate\\Pipeline\\{closure}",
      "class": "Illuminate\\Pipeline\\Pipeline",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
      "line": 183,
      "function": "handle",
      "class": "Illuminate\\Auth\\Middleware\\Authenticate",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
      "line": 119,
      "function": "Illuminate\\Pipeline\\{closure}",
      "class": "Illuminate\\Pipeline\\Pipeline",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php",
      "line": 807,
      "function": "then",
      "class": "Illuminate\\Pipeline\\Pipeline",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php",
      "line": 786,
      "function": "runRouteWithinStack",
      "class": "Illuminate\\Routing\\Router",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php",
      "line": 750,
      "function": "runRoute",
      "class": "Illuminate\\Routing\\Router",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Routing/Router.php",
      "line": 739,
      "function": "dispatchToRoute",
      "class": "Illuminate\\Routing\\Router",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php",
      "line": 201,
      "function": "dispatch",
      "class": "Illuminate\\Routing\\Router",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
      "line": 144,
      "function": "Illuminate\\Foundation\\Http\\{closure}",
      "class": "Illuminate\\Foundation\\Http\\Kernel",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php",
      "line": 21,
      "function": "Illuminate\\Pipeline\\{closure}",
      "class": "Illuminate\\Pipeline\\Pipeline",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ConvertEmptyStringsToNull.php",
      "line": 31,
      "function": "handle",
      "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
      "line": 183,
      "function": "handle",
      "class": "Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php",
      "line": 21,
      "function": "Illuminate\\Pipeline\\{closure}",
      "class": "Illuminate\\Pipeline\\Pipeline",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TrimStrings.php",
      "line": 51,
      "function": "handle",
      "class": "Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
      "line": 183,
      "function": "handle",
      "class": "Illuminate\\Foundation\\Http\\Middleware\\TrimStrings",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Http/Middleware/ValidatePostSize.php",
      "line": 27,
      "function": "Illuminate\\Pipeline\\{closure}",
      "class": "Illuminate\\Pipeline\\Pipeline",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
      "line": 183,
      "function": "handle",
      "class": "Illuminate\\Http\\Middleware\\ValidatePostSize",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/PreventRequestsDuringMaintenance.php",
      "line": 110,
      "function": "Illuminate\\Pipeline\\{closure}",
      "class": "Illuminate\\Pipeline\\Pipeline",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
      "line": 183,
      "function": "handle",
      "class": "Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Http/Middleware/HandleCors.php",
      "line": 62,
      "function": "Illuminate\\Pipeline\\{closure}",
      "class": "Illuminate\\Pipeline\\Pipeline",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
      "line": 183,
      "function": "handle",
      "class": "Illuminate\\Http\\Middleware\\HandleCors",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Http/Middleware/TrustProxies.php",
      "line": 58,
      "function": "Illuminate\\Pipeline\\{closure}",
      "class": "Illuminate\\Pipeline\\Pipeline",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
      "line": 183,
      "function": "handle",
      "class": "Illuminate\\Http\\Middleware\\TrustProxies",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/InvokeDeferredCallbacks.php",
      "line": 22,
      "function": "Illuminate\\Pipeline\\{closure}",
      "class": "Illuminate\\Pipeline\\Pipeline",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
      "line": 183,
      "function": "handle",
      "class": "Illuminate\\Foundation\\Http\\Middleware\\InvokeDeferredCallbacks",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php",
      "line": 119,
      "function": "Illuminate\\Pipeline\\{closure}",
      "class": "Illuminate\\Pipeline\\Pipeline",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php",
      "line": 176,
      "function": "then",
      "class": "Illuminate\\Pipeline\\Pipeline",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php",
      "line": 145,
      "function": "sendRequestThroughRouter",
      "class": "Illuminate\\Foundation\\Http\\Kernel",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Application.php",
      "line": 1188,
      "function": "handle",
      "class": "Illuminate\\Foundation\\Http\\Kernel",
      "type": "->"
    },
    {
      "file": "/var/www/html/public/index.php",
      "line": 17,
      "function": "handleRequest",
      "class": "Illuminate\\Foundation\\Application",
      "type": "->"
    },
    {
      "file": "/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php",
      "line": 23,
      "function": "require_once"
    }
  ]
}
```

