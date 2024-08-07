<?php

namespace App\Repositories;

use App\Models\Holiday;
use App\Interfaces\HolidayRepositoryInterface;

class HolidayRepository implements HolidayRepositoryInterface
{
   public function index()
   {
      return Holiday::query()->where(
         'user_id',
         Auth()->user()->id
      )->with('user')->get();
   }

   public function getById($id)
   {
      return Holiday::findOrFail($id);
   }

   public function store(array $data)
   {
      return Holiday::create($data);
   }

   public function update(array $data, $id)
   {
      return Holiday::whereId($id)->update($data);
   }

   public function delete($id)
   {
      Holiday::destroy($id);
   }
}
