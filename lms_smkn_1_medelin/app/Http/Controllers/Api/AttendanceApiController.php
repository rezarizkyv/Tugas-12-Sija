<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Geofence;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttendanceApiController extends Controller
{
    /**
     * Mobile API: Check-in Geolocation Attendance
     * POST /api/v1/attendance/check-in
     */
    public function checkIn(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'photo' => 'nullable|string', // Base64 or URL
        ]);

        // Default SMKN 1 Medelin Geofence
        $geofence = Geofence::first() ?? new Geofence([
            'name' => 'SMKN 1 Medelin',
            'latitude' => -6.402484,
            'longitude' => 106.836100,
            'radius_meters' => 150,
        ]);

        $distance = $geofence->calculateDistance($validated['latitude'], $validated['longitude']);
        $isValidLocation = $distance <= $geofence->radius_meters;

        if (!$isValidLocation) {
            return response()->json([
                'status' => 'error',
                'code' => 422,
                'message' => "Presensi Gagal! Lokasi Anda berada {$distance}m di luar radius area sekolah ({$geofence->radius_meters}m).",
                'data' => [
                    'distance_meters' => $distance,
                    'allowed_radius' => $geofence->radius_meters,
                    'is_valid_location' => false,
                ]
            ], 422);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Presensi Berhasil Terkonfirmasi Via GPS Radius Sekolah.',
            'data' => [
                'user_id' => $request->user()->id ?? 1,
                'check_in' => now()->toIso8601String(),
                'distance_meters' => $distance,
                'is_valid_location' => true,
                'status' => 'hadir',
            ]
        ]);
    }

    /**
     * Mobile API: Get Attendance History
     * GET /api/v1/attendance/history
     */
    public function history(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'summary' => [
                    'hadir' => 18,
                    'terlambat' => 1,
                    'izin' => 0,
                    'sakit' => 0,
                    'percentage' => 98.0,
                ],
                'logs' => [
                    ['date' => '2026-09-15', 'check_in' => '07:12:45', 'status' => 'hadir', 'distance' => '24.5m'],
                    ['date' => '2026-09-14', 'check_in' => '07:05:12', 'status' => 'hadir', 'distance' => '18.2m'],
                ]
            ]
        ]);
    }
}
