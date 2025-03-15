<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{





    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;

    public function definition(): array
    {
        $productNames = [
            ['en' => 'Laptop', 'ar' => 'لابتوب'],
            ['en' => 'Smartphone', 'ar' => 'هاتف ذكي'],
            ['en' => 'Tablet', 'ar' => 'جهاز لوحي'],
            ['en' => 'Headphones', 'ar' => 'سماعات'],
            ['en' => 'Camera', 'ar' => 'كاميرا'],
            ['en' => 'Smartwatch', 'ar' => 'ساعة ذكية'],
            ['en' => 'Monitor', 'ar' => 'شاشة'],
            ['en' => 'Keyboard', 'ar' => 'لوحة مفاتيح'],
            ['en' => 'Mouse', 'ar' => 'فأرة'],
            ['en' => 'Printer', 'ar' => 'طابعة'],
            ['en' => 'Scanner', 'ar' => 'ماسح ضوئي'],
            ['en' => 'Speakers', 'ar' => 'مكبرات صوت'],
            ['en' => 'External Hard Drive', 'ar' => 'قرص صلب خارجي'],
            ['en' => 'USB Flash Drive', 'ar' => 'محرك أقراص فلاش USB'],
            ['en' => 'Wireless Charger', 'ar' => 'شاحن لاسلكي'],
            ['en' => 'Gaming Console', 'ar' => 'وحدة تحكم ألعاب'],
            ['en' => 'Graphics Card', 'ar' => 'بطاقة رسومات'],
            ['en' => 'Router', 'ar' => 'راوتر'],
            ['en' => 'Power Bank', 'ar' => 'بنك طاقة'],
            ['en' => 'VR Headset', 'ar' => 'نظارة واقع افتراضي'],
            ['en' => 'Microphone', 'ar' => 'ميكروفون'],
            ['en' => 'Projector', 'ar' => 'جهاز عرض'],
            ['en' => 'Smart TV', 'ar' => 'تلفاز ذكي'],
            ['en' => 'E-Reader', 'ar' => 'قارئ إلكتروني'],
            ['en' => 'Bluetooth Speaker', 'ar' => 'مكبر صوت بلوتوث'],
            ['en' => 'Drone', 'ar' => 'طائرة بدون طيار'],
            ['en' => 'Fitness Tracker', 'ar' => 'متعقب اللياقة البدنية'],
            ['en' => 'Desktop Computer', 'ar' => 'كمبيوتر مكتبي'],
            ['en' => 'Smart Home Hub', 'ar' => 'مركز تحكم ذكي'],
            ['en' => 'Wireless Earbuds', 'ar' => 'سماعات أذن لاسلكية'],
            ['en' => 'Car Charger', 'ar' => 'شاحن سيارة'],
            ['en' => 'Cooling Pad', 'ar' => 'لوحة تبريد'],
            ['en' => 'Memory Card', 'ar' => 'بطاقة ذاكرة'],
            ['en' => 'Portable SSD', 'ar' => 'قرص SSD محمول'],
            ['en' => 'HDMI Cable', 'ar' => 'كابل HDMI'],
            ['en' => 'Mechanical Keyboard', 'ar' => 'لوحة مفاتيح ميكانيكية'],
            ['en' => 'Ergonomic Mouse', 'ar' => 'فأرة مريحة'],
            ['en' => 'Surge Protector', 'ar' => 'واقي من التيار المتغير'],
            ['en' => 'Webcam', 'ar' => 'كاميرا ويب']
        ];

        $randomProduct = $this->faker->randomElement($productNames);

        return [
            'name' => [
                'en' => $randomProduct['en'],
                'ar' => $randomProduct['ar']
            ],
            'price' => $this->faker->randomFloat(2, 50, 2000), // Price between $50 and $2000
            'stock' => $this->faker->numberBetween(1, 100) // Stock between 1 and 100
        ];
    }
}
