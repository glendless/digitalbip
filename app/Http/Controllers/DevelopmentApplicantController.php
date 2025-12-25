<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\DevelopmentApplicantStoreRequest;
use App\Http\Requests\DevelopmentApplicantUpdateRequest;
use App\Http\Resources\DevelopmentApplicantResource;
use App\Http\Resources\PaginatedResource;
use App\Interfaces\DevelopmentApplicantRepositoryInterface;
use Illuminate\Http\Request;

class DevelopmentApplicantController extends Controller
{
    private DevelopmentApplicantRepositoryInterface $developmentApplicantRepository;

    public function __construct(DevelopmentApplicantRepositoryInterface $developmentApplicantRepository)
    {
        $this->developmentApplicantRepository = $developmentApplicantRepository;

    }

    public function index(Request $request)
    {
        try {
            $developmentApplicants = $this->developmentApplicantRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data Pelamar Pembangunan Berhasil Diambil', DevelopmentApplicantResource::collection($developmentApplicants), 200);

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
            $developmentApplicants = $this->developmentApplicantRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );

            return ResponseHelper::jsonResponse(true, 'Data Pelamar Pembangunan Berhasil Diambil', PaginatedResource::make($developmentApplicants, DevelopmentApplicantResource::class), 200);

        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(DevelopmentApplicantStoreRequest $request)
    {
        $request = $request->validated();

        try {
            $developmentApplicant = $this->developmentApplicantRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Data Pendaftar Pembangunan Berhasil Ditambahkan', new DevelopmentApplicantResource($developmentApplicant), 201);

        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show(string $id)
    {
        try {

            $developmentApplicants = $this->developmentApplicantRepository->getById($id);

            if (!$developmentApplicants) {
                return ResponseHelper::jsonResponse(false, 'Data Pendaftar Pembangunan Tidak Ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data Pendaftar Pembangunan Berhasil Diambil', new DevelopmentApplicantResource($developmentApplicants), 200);

        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

     public function update(DevelopmentApplicantUpdateRequest $request, string $id)
    {
        $request = $request->validated();

        try {

            $developmentApplicants = $this->developmentApplicantRepository->getById($id);

            if (!$developmentApplicants) {
                return ResponseHelper::jsonResponse(false, 'Data Pendaftar Pembangunan Tidak Ditemukan', null, 404);
            }

            $developmentApplicants = $this->developmentApplicantRepository->update($id, $request);

            return ResponseHelper::jsonResponse(true, 'Data Pendaftar Pembangunan Berhasil Diperbarui', new DevelopmentApplicantResource($developmentApplicants), 200);

        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy(string $id)
    {
           try {
            $developmentApplicants = $this->developmentApplicantRepository->getById($id);

            if (!$developmentApplicants) {
                return ResponseHelper::jsonResponse(false, 'Data Pendaftar Pembangunan Tidak Ditemukan', null, 404);
            }

            $developmentApplicants = $this->developmentApplicantRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Data Pendaftar Pembangunan Berhasil Dihapus', null, 200);

        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

}

