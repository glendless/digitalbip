<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\EventParticipantStoreRequest;
use App\Http\Requests\EventParticipantUpdateRequest;
use App\Http\Resources\EventParticipantResource;
use App\Http\Resources\PaginatedResource;
use App\Interfaces\EventParticipantRepositoryInterface;
use Illuminate\Http\Request;

class EventParticipantController extends Controller
{
    private EventParticipantRepositoryInterface $eventParticipantRepository;

    public function __construct(EventParticipantRepositoryInterface $eventParticipantRepository)
    {
        $this->eventParticipantRepository = $eventParticipantRepository;
    }

    public function index(Request $request)
    {
        try {
            $eventParticipants = $this->eventParticipantRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data Event Berhasil Diambil', EventParticipantResource::collection($eventParticipants), 200);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

     public function getAllPaginated(Request $request)
    {
        $request = $request->validate([
            'search' => 'nullable|string',
            'row_per_page' => 'required|integer'
        ]);

        try {
            $eventParticipants = $this->eventParticipantRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page'],
            );

            return ResponseHelper::jsonResponse(true, 'Data Event Berhasil Diambil', PaginatedResource::make($eventParticipants, EventParticipantResource::class), 200);

        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show(string $id)
    {
        try {
            $eventParticipant = $this->eventParticipantRepository->getById($id);

            if (!$eventParticipant) {
                return ResponseHelper::jsonResponse(false, 'Data Event Tidak Ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data Event Berhasil Ditemukan', new EventParticipantResource($eventParticipant), 200);

        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(EventParticipantStoreRequest $request)
    {
        $request = $request->validated();

         try {
            $eventParticipant = $this->eventParticipantRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Data Event Berhasil Ditambahkan', new EventParticipantResource($eventParticipant), 201);

        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function update(EventParticipantUpdateRequest $request, string $id)
    {

        $request = $request->validated();

         try {
            $eventParticipant = $this->eventParticipantRepository->getById($id);

            if (!$eventParticipant) {
                return ResponseHelper::jsonResponse(false, 'Data Event Tidak Ditemukan', null, 404);
            }

            $eventParticipant = $this->eventParticipantRepository->update($id, $request);

            return ResponseHelper::jsonResponse(true, 'Data Event Berhasil Diperbarui', new EventParticipantResource($eventParticipant), 200);

        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy(string $id)
    {
         try {
            $eventParticipant = $this->eventParticipantRepository->getById($id);

            if (!$eventParticipant) {
                return ResponseHelper::jsonResponse(false, 'Data Event Tidak Ditemukan', null, 404);
            }

            $eventParticipant = $this->eventParticipantRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Data Event Berhasil Dihapus', null, 200);

        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

}
