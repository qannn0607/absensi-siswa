<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    public function model(array $row)
    {
        $kelas = Kelas::whereRaw('LOWER(nama_kelas) = ?', [strtolower(trim($row['kelas']))])->first();
        if (!$kelas) return null;

        if (Siswa::where('nis', $row['nisn'])->exists()) return null;

        // Handle format jenis kelamin
        $jenisKelamin = strtoupper(trim($row['jenis_kelamin']));
        if (in_array($jenisKelamin, ['LAKI-LAKI', 'LAKI', 'L'])) {
            $jenisKelamin = 'L';
        } elseif (in_array($jenisKelamin, ['PEREMPUAN', 'P'])) {
            $jenisKelamin = 'P';
        }

        try {
            $user = User::create([
                'name'     => $row['name'],
                'email'    => null,
                'password' => Hash::make($row['password'] ?? '12345678'),
                'role'     => 'siswa',
            ]);

            return new Siswa([
                'user_id'       => $user->id,
                'kelas_id'      => $kelas->id,
                'nis'           => $row['nisn'],
                'jenis_kelamin' => $jenisKelamin,
                'foto'          => null,
            ]);

        } catch (\Exception $e) {
            return null;
        }
    }
}
