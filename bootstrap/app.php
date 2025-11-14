  <?php

  use Illuminate\Foundation\Application;
  use Illuminate\Foundation\Configuration\Exceptions;
  use Illuminate\Foundation\Configuration\Middleware;
  use App\Http\Middleware\LocaleMiddleware;
  use App\Http\Middleware\RoleMiddleware;

  return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
      web: __DIR__ . '/../routes/web.php',
      api: __DIR__.'/../routes/api.php', // ✅ Add this line
      commands: __DIR__ . '/../routes/console.php',
      health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

      // Your existing web middleware
      $middleware->web(LocaleMiddleware::class);

      // 🔥 Add your role alias here
      $middleware->alias([
          'role' => RoleMiddleware::class,
      ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
      //
    })->create();
