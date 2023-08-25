<?php

namespace App\Exceptions;

use App\Traits\ResponseTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{

    use ResponseTrait;
    // protected $appBaseController;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];


    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return $this->sendError($exception->getMessage());
        } else if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->sendError('Method Not Allowed - \n' . $exception->getMessage());
        } else if ($exception instanceof NotFoundHttpException) {
            return $this->sendError('Route not found - ' . $exception->getMessage());
        } else if ($exception instanceof QueryException) {
            // mySql exception handling
            $message = $this->getMySqlError($exception->getCode());
            $message = ($message) ? $message  : $exception->getMessage();
            return $this->sendError($message, 422);
        } else {
            return $this->sendError($exception->getMessage(), 400);
        }
        return parent::render($request, $exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // Custom handling/reporting for CustomException
            // For example, send an email to the admin
            // Mail::to('admin@example.com')->send(new ExceptionNotification($e));
        });
    }


    private function getMySqlError($code)
    {

        $errors_array = [
            '22001' => "Data too long for column",
            '23000' => "Duplicate entry for unique constrain",
            '23001' => "Restrict violation",
            '23002' => "Set null violation",
            '23003' => "Set default violation",
            '23004' => "Integrity constraint violation - check constraint",
            '23005' => "Integrity constraint violation - unique constraint",
            '23502' => "Not null violation",
            '23503' => "Foreign key violation",
            '23505' => "Unique constraint violation",
            '23514' => "Check constraint violation",
            '42000' => "Syntax error or access violation",
            '42601' => "Syntax error",
            '42702' => "Ambiguous column",
            '42703' => "Undefined column",
            '42704' => "Undefined object",
            '42710' => "Duplicate alias",
            '42712' => "Subquery returns more than one row",
            '42725' => "Subquery is not supported in this context",
            '42802' => "Undefined parameter",
            '42803' => "Grouping error",
            '42804' => "Datatype mismatch",
            '42809' => "Wrong number of arguments",
            '42812' => "Subquery returned no data",
            '42S02' => "Base table or view not found",
            '42S12' => "Subquery returns more than 1 row",
            '42S21' => "Column already exists",
            '42S22' => "Column not found",
            '42S36' => "Column name in table specification is ambiguous",
        ];

        return $errors_array[$code];
    }
}
