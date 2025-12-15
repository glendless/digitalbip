<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\SocialAssistanceRecipientStoreRequest;
use App\Http\Requests\SocialAssistanceRecipientUpdateRequest;
use App\Http\Resources\PaginatedResource;
use App\Http\Resources\SocialAssistanceRecipientResource;
use App\Interfaces\SocialAssistanceRecipientRepositoryInterface;
use App\Models\SocialAssistanceRecipient;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SocialAssistanceRecipientController extends Controller
{
    private SocialAssistanceRecipientRepositoryInterface $socialAssistanceRecipientRepository;

    public function __construct(SocialAssistanceRecipientRepositoryInterface $socialAssistanceRecipientRepository)
    {
        $this->socialAssistanceRecipientRepository = $socialAssistanceRecipientRepository;
    }

    public function index(Request $request) {
        try {
            $socialAssistanceRecipients = $this->socialAssistanceRecipientRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

           return ResponseHelper::JsonResponse(true, 'Data Penerima Bantuan Sosial Berhasil Diambil', SocialAssistanceRecipientResource::collection($socialAssistanceRecipients), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request) {
        $request = $request->validate([
            'search' => 'nullable|string',
            'row_per_page' => 'nullable|integer',
        ]);

        try {
            $socialAssistanceRecipients = $this->socialAssistanceRecipientRepository->getAllPaginated(
                $request['search'],
                $request['row_per_page'],
            );

            return ResponseHelper::jsonResponse(true, 'Data Penerima Bantuan Sosial Berhasil Diambil', PaginatedResource::make($socialAssistanceRecipients, SocialAssistanceRecipientResource::class), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Data Penerima Bantuan Sosial Gagal Diambil', $e->getMessage(), null, 500);
        }
    }

    public function store (SocialAssistanceRecipientStoreRequest $request) {

        $request = $request->validated();

       try {
            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->create($request);
            return ResponseHelper::JsonResponse(true, 'Data Penerima Bantuan Sosial Berhasil Dibuat', new SocialAssistanceRecipientResource($socialAssistanceRecipient), 200);
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show(string $id) {
        try {
            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->getById($id);

            if (!$socialAssistanceRecipient) {
                return ResponseHelper::jsonResponse(false, 'Data Penerima Bantuan Sosial Tidak Ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data Penerima Bantuan Sosial Berhasil Ditemukan', new SocialAssistanceRecipientResource($socialAssistanceRecipient), 200);
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function update(SocialAssistanceRecipientUpdateRequest $request, string $id) {

         $request = $request->validated();

       try {
            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->getById($id);

            if (!$socialAssistanceRecipient) {
                return ResponseHelper::jsonResponse(false, 'Data Penerima Bantuan Sosial Tidak Ditemukan', null, 404);
            }

            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->update($id, $request);

            return ResponseHelper::JsonResponse(true, 'Data Penerima Bantuan Sosial Berhasil Diperbarui', new SocialAssistanceRecipientResource($socialAssistanceRecipient), 200);
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy(string $id) {

       try {
            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->getById($id);

            if (!$socialAssistanceRecipient) {
                return ResponseHelper::jsonResponse(false, 'Data Penerima Bantuan Sosial Tidak Ditemukan', null, 404);
            }

            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->delete($id);

            return ResponseHelper::JsonResponse(true, 'Data Penerima Bantuan Sosial Berhasil Dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::JsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
