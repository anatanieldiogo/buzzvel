<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHolidayRequest;
use App\Http\Requests\UpdateHolidayRequest;
use App\Interfaces\HolidayRepositoryInterface;
use App\Models\Holiday;
use App\Classes\ApiResponseClass;
use App\Http\Resources\HolidayResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf;

class HolidayController extends Controller
{

    private HolidayRepositoryInterface $holidayRepositoryInterface;

    public function __construct(HolidayRepositoryInterface $holidayRepositoryInterface)
    {
        $this->holidayRepositoryInterface = $holidayRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->holidayRepositoryInterface->index();

        return ApiResponseClass::sendResponse(HolidayResource::collection($data), '', 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHolidayRequest $request)
    {
        $details = [
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'location' => $request->location,
            'user_id' => Auth()->user()->id,
        ];

        DB::beginTransaction();

        try {
            $holiday = $this->holidayRepositoryInterface->store($details);

            DB::commit();

            return ApiResponseClass::sendResponse(new HolidayResource($holiday), 'Holiday Created Successful', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        try {
            $holiday = $this->holidayRepositoryInterface->getById($id);

            if (!Gate::allows('holiday-owner', $holiday)) {

                return response()->json([
                    'message' => 'unauthorized'
                ]);
            }
        } catch (ModelNotFoundException $e) {

            return response()->json(['message' => 'Holiday not found'], 404);
        }

        return ApiResponseClass::sendResponse(new HolidayResource($holiday), '', 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Holiday $holiday)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHolidayRequest $request, $id)
    {
        try {
            $holiday = $this->holidayRepositoryInterface->getById($id);

            if (!Gate::allows('holiday-owner', $holiday)) {

                return response()->json([
                    'message' => 'unauthorized'
                ]);
            }
        } catch (ModelNotFoundException $e) {

            return response()->json(['message' => 'Holiday not found'], 404);
        }


        $updateDetails = [
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'location' => $request->location,
        ];

        DB::beginTransaction();

        try {
            $holiday = $this->holidayRepositoryInterface->update($updateDetails, $id);

            DB::commit();
            return ApiResponseClass::sendResponse('Holiday Updated Successful', '', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    public function report($id)
    {
        try {
            $holiday = $this->holidayRepositoryInterface->getById($id);

            if (!Gate::allows('holiday-owner', $holiday)) {

                return response()->json([
                    'message' => 'unauthorized'
                ]);
            }

            $data = [
                'user' => Auth()->user(),
                'holiday' => $holiday,
            ];

            $pdf = Pdf::loadView('Reports.holiday', compact('data'));
            return $pdf->download('Holiday.pdf');
        } catch (ModelNotFoundException $e) {

            return response()->json(['message' => 'Holiday not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $holiday = $this->holidayRepositoryInterface->getById($id);

            if (!Gate::allows('holiday-owner', $holiday)) {

                return response()->json([
                    'message' => 'unauthorized'
                ]);
            }
        } catch (ModelNotFoundException $e) {

            return response()->json(['message' => 'Holiday not found'], 404);
        }

        try {
            $holiday = $this->holidayRepositoryInterface->delete($id);

            return ApiResponseClass::sendResponse('Holiday Deleted Successful', '', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }
}
