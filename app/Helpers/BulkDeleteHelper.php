<?php

namespace App\Helpers;

use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class BulkDelete
{

    /**
     * Bulk delete data
     *
     * @param string $message Success message
     * @param string $model Model name
     * @param array $ids Array of ids
     * @return JsonResponse|Response
     */
    public static function delete($message, $model, $ids) : JsonResponse|Response
    {
        // Validate payload
        if (!$ids) {
            return HttpResponse::fail(Response::HTTP_UNPROCESSABLE_ENTITY, 'Invalid payload', [
                'ids' => ['Ids harus diisi']
            ]);
        }
        if (!is_array($ids)) {
            return HttpResponse::fail(Response::HTTP_UNPROCESSABLE_ENTITY, 'Invalid payload', [
                'ids' => ['Ids harus berupa array']
            ]);
        }

        // Delete data
        foreach ($ids as $id) {
            $data = $model::find($id);
            if (!$data) {
                continue;
            }

            // check if model is Lecturer
            if ($model == 'App\Models\Lecturer') {
                if ($data->is_admin) {
                    continue;
                }
            }

            $data->delete();
        }

        // Return response
        return HttpResponse::success(Response::HTTP_OK, $message . ' deleted successfully');
    }
}
