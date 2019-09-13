<?php
namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ExceptionTrait 
{
    public function apiException($request, $exception)
    {
        if($this->isModel($exception))
        {
            return $this->modelResponse($exception);
        }

        if($this->isHttp($exception))
        {
           return $this->httpResponse($exception);
        }
        return parent::render($request, $exception);
 
    }
    protected function isModel($exception) 
    {
        return $exception instanceof ModelNotFoundException;
    }
    
    protected function isHttp($exception)
    {
        return $exception instanceof NotFoundHttpException;
    }
    
    protected function modelResponse($exception)
    {
        return response()->json([
            'errors' => 'Product Not Found',
        ], Response::HTTP_NOT_FOUND);
    }
    
    protected function httpResponse($exception)
    {
        return response()->json([
            'errors' => 'Incorrect URL',
        ], Response::HTTP_NOT_FOUND);
    }
    
}

