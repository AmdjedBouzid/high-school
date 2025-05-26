<?php

// namespace App\Http\Resources;

// use Illuminate\Http\Request;
// use Illuminate\Http\Resources\Json\ResourceCollection;

// class StudentCollection extends ResourceCollection
// {
//     public function toArray($request)
//     {
//         // Check if the collection is paginated
//         $isPaginated = method_exists($this->collection, 'total');

//         $data = [
//             'data' => $this->collection,
//             'links' => [
//                 'self' => url()->current(),
//             ],
//         ];

//         // Only include pagination metadata if paginated
//         if ($isPaginated) {
//             $data['meta'] = [
//                 'total' => $this->total(),
//                 'count' => $this->count(),
//                 'per_page' => $this->perPage(),
//                 'current_page' => $this->currentPage(),
//                 'total_pages' => $this->lastPage(),
//             ];
//         }

//         return $data;
//     }
// } 
