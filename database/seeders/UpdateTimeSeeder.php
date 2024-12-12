<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
class UpdateTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lấy ngày hôm nay
        $today = Carbon::now()->subWeek(1);

        // Lấy danh sách tất cả các bảng trong cơ sở dữ liệu
        $tables = DB::select('SHOW TABLES');

        // Lặp qua từng bảng và cập nhật 'created_at' và 'updated_at'
        foreach ($tables as $table) {
            $tableName = $table->{"Tables_in_" . env('DB_DATABASE')};  // Lấy tên bảng (tên database là biến trong config .env)

            // Kiểm tra nếu bảng có cột 'created_at' và 'updated_at'
            if (Schema::hasColumns($tableName, ['created_at', 'updated_at'])) {
                DB::table($tableName)->update([
                    'created_at' => $today,
                    'updated_at' => $today,
                ]);
            }
        }
    }
}
