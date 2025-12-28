<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\DevelopmentStoreRequest;
use App\Http\Requests\DevelopmentUpdateRequest;
use App\Http\Resources\DevelopmentResource;
use App\Http\Resources\PaginatedResource;
use App\Repositories\DevelopmentRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class DevelopmentController extends Controller implements HasMiddleware
{
    private DevelopmentRepository $developmentRepository;

    public function __construct(DevelopmentRepository $developmentRepository)
    {
        $this->developmentRepository = $developmentRepository;
    }

     public static function middleware()
    {
        return [
            new Middleware(PermissionMiddleware::using(['development-list|development-create|development-edit|development-delete']), only: ['index', 'getAllPaginated', 'show']),
            new middleware(PermissionMiddleware::using(['development-create']), only: ['store']),
            new middleware(PermissionMiddleware::using(['development-edit']), only: ['update']),
            new middleware(PermissionMiddleware::using(['development-delete']), only: ['destroy']),
        ];
    }

     public function index(Request $request)
    {
        try {
            $developments = $this->developmentRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data Pembangunan Berhasil Diambil', DevelopmentResource::collection($developments), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $request = $request->validate([
            'search' => 'nullable|string',
            'row_per_page' => 'required|integer'
        ]);

        try {
            $developments = $this->developmentRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page'],
            );

            return ResponseHelper::jsonResponse(true, 'Data Pembangunan Berhasil Diambil', PaginatedResource::make($developments, DevelopmentResource::class), 200);

        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(DevelopmentStoreRequest $request)
    {
        $request = $request->validated();

        try {
            $development = $this->developmentRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Pembangunan Berhasil Ditambahkan', new DevelopmentResource($development), 201);

        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show(string $id)
    {
         try {
            $development = $this->developmentRepository->getById($id);

            if (!$development) {
                return ResponseHelper::jsonResponse(true, 'Data Pembangunan Tidak Ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Pembangunan Berhasil Diambil', new DevelopmentResource($development), 200);

        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function update(DevelopmentUpdateRequest $request,string $id)
    {

        $request = $request->validated();

         try {
            $development = $this->developmentRepository->getById($id);

            if (!$development) {
                return ResponseHelper::jsonResponse(true, 'Data Pembangunan Tidak Ditemukan', null, 404);
            }

            $development = $this->developmentRepository->update($id, $request);

            return ResponseHelper::jsonResponse(true, 'Pembangunan Berhasil Diperbarui', new DevelopmentResource($development), 200);

        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy(string $id)
    {
         try {
            $development = $this->developmentRepository->getById($id);

            if (!$development) {
                return ResponseHelper::jsonResponse(true, 'Data Pembangunan Tidak Ditemukan', null, 404);
            }

            $development = $this->developmentRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Pembangunan Berhasil Dihapus', null, 200);

        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
