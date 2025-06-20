<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'category_id' => 1,
                'brand_id' => 1,
                'name' => 'Giày Ultraboost 5x',
                'slug' => Str::slug('Giày Ultraboost 5x'),
                'description' => '<p>Đôi giày chạy bộ BOOST thế hệ mới có sử dụng chất liệu tái chế.
                                    Chinh phục kỷ lục cá nhân mới thật dễ dàng với đôi giày chạy bộ adidas này. Đế BOOST nhẹ nhất từ trước 
                                    đến nay của chúng tôi hoàn trả năng lượng liên tục trên từng cây số để bạn cảm thấy sung sức từ đầu đến
                                    cuối buổi chạy. Hệ thống Torsion System giữa gót giày và mũi giày tạo độ ổn định, cho sải bước mượt mà,
                                    vững chãi bất kể cự ly hay tốc độ nào. Tất cả được đặt trên đế ngoài Continental™ Rubber với độ bám chắc
                                    chắn cả trong điều kiện khô ráo cũng như ẩm ướt để bạn luôn tự tin sải bước. Sản phẩm này có chứa tối thiểu
                                        20% chất liệu tái chế. Bằng cách tái sử dụng các chất liệu đã được tạo ra, chúng tôi góp phần giảm thiểu lãng
                                        phí và hạn chế phụ thuộc vào các nguồn tài nguyên hữu hạn, cũng như giảm phát thải từ các sản phẩm mà chúng tôi
                                        sản xuất.</p>',
                'discount' => 2,
                'sku' => 'ADD21335',
                'featured' => 1,
                'view' => 150,
                'sales_count' => 30,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 1,
                'brand_id' => 1,
                'name' => 'Giày Samba ORIGINALS',
                'slug' => Str::slug('Giày Samba ORIGINALS'),
                'description' => '<p>SAMBA ORIGINALS
                                    Ra đời trên sân bóng, giày Samba là biểu tượng kinh điển của phong cách đường phố. 
                                    Phiên bản này trung thành với di sản, thể hiện qua thân giày bằng da mềm, dáng thấp,
                                    nhã nhặn, các chi tiết phủ ngoài bằng da lộn và đế gum, biến đôi giày trở thành item
                                    không thể thiếu trong tủ đồ của tất cả mọi người - cả trong và ngoài sân cỏ.</p>',
                'discount' => 2,
                'sku' => 'QJN67890',
                'featured' => 0,
                'view' => 200,
                'sales_count' => 50,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 1,
                'brand_id' => 3,
                'name' => 'Giày Puma Speedcat Leather',
                'slug' => Str::slug('Giày Puma Speedcat Leather'),
                'description' => '<p>Speedcat mang tính biểu tượng được tái sinh trên đường phố. 
                                    Da cao cấp và thiết kế táo bạo kết hợp di sản đua xe thể thao với phong cách hiện đại. 
                                    Thương hiệu được sơn và dập nổi mang lại thái độ không thể nhầm lẫn dưới chân, trong khi lớp 
                                    lót OrthoLite® đảm bảo sự thoải mái cả ngày cho những người luôn di chuyển.</p>',
                'discount' => 2,
                'sku' => 'PM038565',
                'featured' => 1,
                'view' => 200,
                'sales_count' => 40,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 1,
                'brand_id' => 2,
                'name' => 'Nike Vomero 18',
                'slug' => Str::slug('Nike Vomero 18'),
                'description' => '<p>Đệm tối đa trong Vomero mang lại cảm giác thoải mái khi chạy hàng ngày. Chuyến đi mềm mại nhất, 
                                    đệm nhất của chúng tôi có bọt ZoomX nhẹ xếp chồng lên trên bọt ReactX nhạy cảm ở đế giữa. Thêm vào đó, kiểu kéo được 
                                    thiết kế lại mang lại sự chuyển đổi mượt mà từ gót chân sang ngón chân.</p>',
                'discount' => 0,
                'sku' => 'NK3853',
                'featured' => 1,
                'view' => 30,
                'sales_count' => 63,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 1,
                'brand_id' => 2,
                'name' => 'Nike Court Vision thấp',
                'slug' => Str::slug('Nike Court Vision thấp'),
                'description' => '<p>Yêu thích vẻ ngoài cổ điển của bóng rổ thập niên 80 nhưng có một thứ gì đó với văn hóa nhịp độ nhanh của trò chơi ngày nay?
                                    Gặp gỡ tầm nhìn của tòa án thấp. Một bản phối lại cổ điển, phần trên sắc nét và lớp phủ được khâu giữ nguyên linh hồn của phong cách ban đầu. 
                                    Cổ áo sang trọng, cắt thấp giữ cho nó bóng bẩy và thoải mái cho thế giới của bạn.</p>',
                'discount' => 0,
                'sku' => 'NK8535',
                'featured' => 1,
                'view' => 30,
                'sales_count' => 35,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => 2,
                'brand_id' => 3,
                'name' => 'Nike Luka .77 PF',
                'slug' => Str::slug('Nike Luka .77 PF'),
                'description' => '<p>Được thiết kế để trở nên khó khăn như trò chơi của Luka, Luka .77 được chế tạo để giúp bạn thống trị
                                    trên các sân ngoài trời gồ ghề. Lưới có độ mài mòn cao và đế ngoài bằng cao su bền đứng vững với bê tông và đường nhựa. 
                                    Đệm Snappy Air Zoom và bọt mật độ kép nhạy cảm giúp bạn thoải mái, vì vậy bạn luôn sẵn sàng cho bất cứ nơi nào trò chơi đưa bạn.</p>',         
                'discount' => 0,
                'sku' => 'NK3236',
                'featured' => 1,
                'view' => 30,
                'sales_count' => 35,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
