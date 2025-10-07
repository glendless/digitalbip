<?php
    namespace App\Repositories;

use App\Interfaces\HeadOfFamilyRepositoryInterface;
use App\Models\HeadOfFamily;
use Exception;
use Illuminate\Support\Facades\DB;

    class HeadOfFamilyRepository implements HeadOfFamilyRepositoryInterface {
        public function getAll(
        ?string $search,
        ?int $limit,
        bool $execute
        )

        {
         $query = HeadOfFamily::where(function ($query) use ($search) {
            if ($search) {
                $query->search($search);
                }
         });

         $query->orderBy('created_at', 'desc');

        if ($limit) {
            // mengambil beberapa data berdasarkan limit
            $query->take($limit);
         }

        if ($execute) {
            return $query->get();
         }

        return $query;
        }

        public function getAllPaginated(
          ?string $search,
          ?int $rowPerPage
        ){
        $query = $this->getAll(
          $search,
          $rowPerPage,
          false
        );

        return $query->paginate($rowPerPage);
      }

      public function create(
        array $data
      ){
        DB::beginTransaction();

        try {
            $userRepository = new UserRepository;

            $user = $userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password']
            ]);

            $headOfFamily = new HeadOfFamily;
            $headOfFamily->user_id = $user->id;
            $headOfFamily->profile_picture = $data['profile_picture']->store('assets/head_of_families', 'public');
            $headOfFamily->identity_number =  $data['identity_number'];
            $headOfFamily->gender = $data['gender'];
            $headOfFamily->date_of_birth = $data['date_of_birth'];
            $headOfFamily->phone_number = $data['phone_number'];
            $headOfFamily->occupation = $data['occupation'];
            $headOfFamily->marital_status = $data['marital_status'];

            $headOfFamily->save();

            DB::commit();

            return $headOfFamily;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
      }

    }

