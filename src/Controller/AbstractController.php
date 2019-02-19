<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AbstractController
 * @package App\Controller
 */
class AbstractController
{
    /**
     * @param string $msg
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function getSuccessJsonResponse(string $msg, $statusCode = JsonResponse::HTTP_OK)
    {
        return new JsonResponse([
            'status' => 'success',
            'msg' => $msg,
        ], $statusCode);
    }

    /**
     * @param \Exception $e
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function getErrorJsonResponse(\Exception $e, $statusCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR)
    {
        return new JsonResponse([
            'status' => 'error',
            'msg' => $e->getMessage(),
        ], $statusCode);
    }
}