<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $permissions = [
        'تقارير الفواتير',
        'تقاريرالعملاء',
        'قائمة الفواتير ',
        'الفواتيرالمدفوعة',
        'الفواتيرالغير مدفوعة',
        'الفواتيرالمدفوعة جزئيا',
        'الارشيف',
        'قائمة المستخدمين',
        'صلاحية المستخدمين',
        'الاقسام',
        'المنتجات',

        ' اضافة فاتورة',
        ' تعديل فاتورة',
        ' حدف فاتورة',
        ' حدف مرفق',
        ' عرض فاتورة',
        ' حالة فاتورة',
        ' تصدير فاتورة',

        ' اضافة صلاحية',
        ' تعديل صلاحية',
        ' حدف صلاحية',
        ' عرض صلاحية',

        'اضافة مستخدم',
        'تعديل مستخدم',
        'حدف مستخدم',

        'اضافة منتج',
        'تعديل منتج',
        'حدف منتج',

        'اضافة قسم',
        'تعديل قسم',
        'حدف قسم',

      ] ;
      foreach ($permissions as $permission) {
       Permission::create(['name'=>$permission]);
      }
    }
}
