<?php

namespace App\Http\Controllers;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UserExport implements FromCollection, WithHeadings,ShouldAutoSize
{
    public function collection()
    {
        // $users = User::select('id', 'name', 'email', 'phonenumber', 'created_at', 'updated_at')
        //     ->with('province', 'district', 'ward')
        //     ->get();
        // dd($users);
        return User::all()->map(function($user){
            
            if($user->address == null){
                $address = '';
            }else{
                $address = $user->_province->name . ',' . $user->_district->name . ',' . $user->_ward->name . ',' . $user->address;
            }
            return [
                $user->id,
                $user->name,
                $user->email,
                $user->phonenumber,
                $address,
                $user->created_at,
                $user->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Address',
            'Created At',
            'Updated At',
        ];
    }
}
