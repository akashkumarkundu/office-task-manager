<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroceryController extends Controller
{
    /**
     * Display Page 2: Grocery Items with photos and Bangladeshi prices (BDT ৳)
     */
    public function index(Request $request)
    {
        $products = $this->getGroceryProducts();

        $selectedCategory = $request->query('category', 'All');
        $searchQuery = trim($request->query('search', ''));

        // Filter by category
        if ($selectedCategory !== 'All' && !empty($selectedCategory)) {
            $products = array_filter($products, function ($item) use ($selectedCategory) {
                return strcasecmp($item['category'], $selectedCategory) === 0;
            });
        }

        // Filter by search query
        if (!empty($searchQuery)) {
            $products = array_filter($products, function ($item) use ($searchQuery) {
                return stripos($item['name'], $searchQuery) !== false ||
                       stripos($item['bengali_name'], $searchQuery) !== false ||
                       stripos($item['category'], $searchQuery) !== false;
            });
        }

        $categories = [
            'All' => 'All Items (সব পণ্য)',
            'Vegetables' => 'Fresh Vegetables (শাকসবজি)',
            'Rice & Grains' => 'Rice & Lentils (চাল ও ডাল)',
            'Cooking Oil' => 'Cooking Oil & Ghee (তেল ও ঘি)',
            'Spices' => 'Spices & Masala (খাঁটি মসলা)',
            'Fish & Meat' => 'Fish & Meat (মাছ ও মাংস)',
            'Dairy & Eggs' => 'Dairy & Eggs (দুধ ও ডিম)',
            'Snacks & Tea' => 'Snacks & Tea (নাস্তা ও চা)',
        ];

        return view('items', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'searchQuery' => $searchQuery,
            'totalCount' => count($products),
        ]);
    }

    /**
     * Authentic Bangladeshi Grocery Dataset
     */
    private function getGroceryProducts()
    {
        return [
            // Fresh Vegetables
            [
                'id' => 'veg-1',
                'name' => 'Fresh Deshi Tomato (টমেটো)',
                'bengali_name' => 'দেশি লাল টমেটো',
                'category' => 'Vegetables',
                'price' => 60,
                'old_price' => 75,
                'unit' => '1 kg',
                'discount' => '20% OFF',
                'badge' => 'Farm Fresh',
                'image' => 'https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=500&q=80',
                'description' => 'Locally grown fresh red tomatoes from Rajshahi agricultural farms. Perfect for salad and curry.'
            ],
            [
                'id' => 'veg-2',
                'name' => 'Fresh Potato / Gol Alu (গোল আলু)',
                'bengali_name' => 'নতুন গোল আলু',
                'category' => 'Vegetables',
                'price' => 45,
                'old_price' => 50,
                'unit' => '1 kg',
                'discount' => null,
                'badge' => 'Daily Essential',
                'image' => 'https://images.unsplash.com/photo-1518977676601-b53f82aba655?w=500&q=80',
                'description' => 'Clean, unblemished high quality potatoes from Northern Bengal farmlands.'
            ],
            [
                'id' => 'veg-3',
                'name' => 'Red Onion / Deshi Piaj (দেশি পেঁয়াজ)',
                'bengali_name' => 'খাঁটি দেশি পেঁয়াজ',
                'category' => 'Vegetables',
                'price' => 90,
                'old_price' => 105,
                'unit' => '1 kg',
                'discount' => '14% OFF',
                'badge' => 'High Demand',
                'image' => 'https://images.unsplash.com/photo-1618512496248-a07fe83aa8cb?w=500&q=80',
                'description' => 'Sharp flavored, well-cured local Deshi onions from Taherpur, Rajshahi.'
            ],
            [
                'id' => 'veg-4',
                'name' => 'Green Chili / Kacha Morich (কাঁচা মরিচ)',
                'bengali_name' => 'তাজা কাঁচা মরিচ',
                'category' => 'Vegetables',
                'price' => 140,
                'old_price' => 160,
                'unit' => '500 g',
                'discount' => null,
                'badge' => 'Spicy & Fresh',
                'image' => 'https://images.unsplash.com/photo-1563565375-f3fdfdbefa83?w=500&q=80',
                'description' => 'Freshly plucked spicy green chilies with intense aroma.'
            ],
            [
                'id' => 'veg-5',
                'name' => 'Pointed Gourd / Potol (পটল)',
                'bengali_name' => 'তাজা দেশি পটল',
                'category' => 'Vegetables',
                'price' => 50,
                'old_price' => 60,
                'unit' => '1 kg',
                'discount' => null,
                'badge' => 'Morning Harvest',
                'image' => 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=500&q=80',
                'description' => 'Tender green pointed gourd harvested early this morning.'
            ],
            [
                'id' => 'veg-6',
                'name' => 'Bitter Gourd / Korola (করলা)',
                'bengali_name' => 'তাজা ছোট করলা',
                'category' => 'Vegetables',
                'price' => 70,
                'old_price' => 80,
                'unit' => '1 kg',
                'discount' => null,
                'badge' => 'Organic',
                'image' => 'https://images.unsplash.com/photo-1601004890684-d8cbf643f5f2?w=500&q=80',
                'description' => 'Crisp organic bitter gourds, rich in antioxidants and vitamins.'
            ],

            // Rice & Grains
            [
                'id' => 'rice-1',
                'name' => 'Miniket Premium Rice (মিনিকেট চাল)',
                'bengali_name' => 'প্রিমিয়াম মিনিকেট চাল',
                'category' => 'Rice & Grains',
                'price' => 78,
                'old_price' => 85,
                'unit' => '1 kg',
                'discount' => 'Popular',
                'badge' => 'Best Seller',
                'image' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=500&q=80',
                'description' => 'Fine grain, beautifully polished, non-sticky Miniket rice ideal for daily meals.'
            ],
            [
                'id' => 'rice-2',
                'name' => 'Nazirshail Special Rice (নাজিরশাইল চাল)',
                'bengali_name' => 'স্পেশাল নাজিরশাইল চাল',
                'category' => 'Rice & Grains',
                'price' => 88,
                'old_price' => 95,
                'unit' => '1 kg',
                'discount' => null,
                'badge' => 'Premium',
                'image' => 'https://images.unsplash.com/photo-1536304993881-ff6e9eefa2a6?w=500&q=80',
                'description' => 'Traditional long-grain Nazirshail rice with authentic natural aroma.'
            ],
            [
                'id' => 'rice-3',
                'name' => 'Chinigura Polao Rice (চিনিগুঁড়া সুগন্ধি চাল)',
                'bengali_name' => 'চিনিগুঁড়া পোলাও চাল',
                'category' => 'Rice & Grains',
                'price' => 140,
                'old_price' => 155,
                'unit' => '1 kg',
                'discount' => '10% OFF',
                'badge' => 'Aromatic',
                'image' => 'https://images.unsplash.com/photo-1568283096533-078a24930eb8?w=500&q=80',
                'description' => 'Sweet aromatic small grain Chinigura rice for delicious Biryani, Polao, and Payesh.'
            ],
            [
                'id' => 'dal-1',
                'name' => 'Deshi Masoor Dal / Red Lentil (মসুর ডাল)',
                'bengali_name' => 'দেশি চিকন মসুর ডাল',
                'category' => 'Rice & Grains',
                'price' => 135,
                'old_price' => 145,
                'unit' => '1 kg',
                'discount' => null,
                'badge' => 'Protein Rich',
                'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&q=80',
                'description' => 'Cleaned, stoneless premium Deshi red lentils for authentic Bengali dal.'
            ],

            // Cooking Oil & Ghee
            [
                'id' => 'oil-1',
                'name' => 'Rupchanda Fortified Soybean Oil (সয়াবিন তেল)',
                'bengali_name' => 'রূপচাঁদা সয়াবিন তেল ১ লিটার',
                'category' => 'Cooking Oil',
                'price' => 185,
                'old_price' => 195,
                'unit' => '1 Litre',
                'discount' => 'Save ৳10',
                'badge' => 'Vitamin A Fortified',
                'image' => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=500&q=80',
                'description' => 'Bangladesh #1 trusted brand refined soybean oil with Vitamin A & D.'
            ],
            [
                'id' => 'oil-2',
                'name' => 'Teer Pure Mustard Oil (তীর খাঁটি সরিষার তেল)',
                'bengali_name' => 'তীর খাঁটি সরিষার তেল',
                'category' => 'Cooking Oil',
                'price' => 260,
                'old_price' => 280,
                'unit' => '1 Litre',
                'discount' => null,
                'badge' => 'Pungent Aroma',
                'image' => 'https://images.unsplash.com/photo-1620706857370-e1b9770e8bb1?w=500&q=80',
                'description' => 'Strong, traditional cold-pressed mustard oil for Bhorta, Ilish, and pickles.'
            ],
            [
                'id' => 'oil-3',
                'name' => 'Aarong Dairy Pure Ghee (আড়ং খাঁটি গাওয়া ঘি)',
                'bengali_name' => 'আড়ং ডেইরি গাওয়া ঘি',
                'category' => 'Cooking Oil',
                'price' => 580,
                'old_price' => 620,
                'unit' => '400 g',
                'discount' => 'Save ৳40',
                'badge' => '100% Pure',
                'image' => 'https://images.unsplash.com/photo-1631451095765-2c91616fc9e6?w=500&q=80',
                'description' => 'Rich golden granular butter ghee made from pure cow milk.'
            ],

            // Spices & Condiments
            [
                'id' => 'spice-1',
                'name' => 'Radhuni Turmeric / Haldi Powder (হলুদ গুঁড়া)',
                'bengali_name' => 'রাঁধুনী খাঁটি হলুদ গুঁড়া',
                'category' => 'Spices',
                'price' => 120,
                'old_price' => 130,
                'unit' => '200 g',
                'discount' => null,
                'badge' => '100% Pure',
                'image' => 'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?w=500&q=80',
                'description' => 'Bright golden turmeric powder processed from top grade Rajshahi turmeric.'
            ],
            [
                'id' => 'spice-2',
                'name' => 'Radhuni Red Chili Powder (মরিচ গুঁড়া)',
                'bengali_name' => 'রাঁধুনী লাল মরিচ গুঁড়া',
                'category' => 'Spices',
                'price' => 140,
                'old_price' => 150,
                'unit' => '200 g',
                'discount' => null,
                'badge' => 'Hot & Vibrant',
                'image' => 'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=500&q=80',
                'description' => 'Fiery red chili powder with natural aroma and deep curry color.'
            ],
            [
                'id' => 'spice-3',
                'name' => 'Whole Garlic / Deshi Roshun (দেশি রসুন)',
                'bengali_name' => 'দেশি কোয়া রসুন',
                'category' => 'Spices',
                'price' => 210,
                'old_price' => 230,
                'unit' => '1 kg',
                'discount' => 'Save ৳20',
                'badge' => 'Fresh Bulb',
                'image' => 'https://images.unsplash.com/photo-1540148426945-6cf22a6b2383?w=500&q=80',
                'description' => 'Aromatic and potent local garlic cloves with thin skin.'
            ],

            // Fish & Meat
            [
                'id' => 'fish-1',
                'name' => 'Padma River Fresh Ilish / Hilsa (পদ্মার ইলিশ)',
                'bengali_name' => 'পদ্মার তাজা বড় ইলিশ',
                'category' => 'Fish & Meat',
                'price' => 1450,
                'old_price' => 1600,
                'unit' => '1 kg (Whole)',
                'discount' => 'Rajshahi Padma Special',
                'badge' => 'Authentic Padma',
                'image' => 'https://images.unsplash.com/photo-1534948216015-843149f72be3?w=500&q=80',
                'description' => 'Famous Rajshahi Padma river silver Hilsa fish. Unmatched sweet taste and rich oil.'
            ],
            [
                'id' => 'fish-2',
                'name' => 'Fresh Live Rui Fish (তাজা রুই মাছ)',
                'bengali_name' => 'মিঠাপানির তাজা রুই মাছ',
                'category' => 'Fish & Meat',
                'price' => 380,
                'old_price' => 410,
                'unit' => '1 kg',
                'discount' => null,
                'badge' => 'Cleaned & Cut Option',
                'image' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=500&q=80',
                'description' => 'Freshwater Rui fish from local ponds in Rajshahi. Available whole or custom cut.'
            ],
            [
                'id' => 'meat-1',
                'name' => 'Fresh Beef / Gorur Mangsho (গরুর মাংস)',
                'bengali_name' => 'তাজা দেশি গরুর মাংস',
                'category' => 'Fish & Meat',
                'price' => 750,
                'old_price' => 780,
                'unit' => '1 kg',
                'discount' => 'Halal Certified',
                'badge' => 'Daily Morning Cut',
                'image' => 'https://images.unsplash.com/photo-1603048588665-791ca8aea617?w=500&q=80',
                'description' => '100% Halal fresh bone-in prime beef cut daily at Rajshahi authorized municipal abattoir.'
            ],
            [
                'id' => 'meat-2',
                'name' => 'Broiler Chicken / Cleaned (ব্রয়লার মুরগি)',
                'bengali_name' => 'পরিষ্কার ব্রয়লার মুরগি',
                'category' => 'Fish & Meat',
                'price' => 210,
                'old_price' => 225,
                'unit' => '1 kg',
                'discount' => null,
                'badge' => 'Skinless / Whole',
                'image' => 'https://images.unsplash.com/photo-1587593810167-a84920ea0781?w=500&q=80',
                'description' => 'Dressed and hygienically packed chicken, processed upon order.'
            ],

            // Dairy & Eggs
            [
                'id' => 'dairy-1',
                'name' => 'Farm Fresh Brown Eggs (ফার্মের লাল ডিম)',
                'bengali_name' => 'ফার্মের তাজা লাল ডিম',
                'category' => 'Dairy & Eggs',
                'price' => 145,
                'old_price' => 155,
                'unit' => '1 Dozen (12 pcs)',
                'discount' => 'Save ৳10',
                'badge' => 'Safe Pack',
                'image' => 'https://images.unsplash.com/photo-1516467508483-a7212febe31a?w=500&q=80',
                'description' => 'Grade A brown poultry eggs packed securely in cushioned egg crates.'
            ],
            [
                'id' => 'dairy-2',
                'name' => 'Aarong Pasteurised Pure Milk (আড়ং তরল দুধ)',
                'bengali_name' => 'আড়ং ফুল ক্রিম তরল দুধ',
                'category' => 'Dairy & Eggs',
                'price' => 90,
                'old_price' => 95,
                'unit' => '1 Litre Pack',
                'discount' => null,
                'badge' => 'Full Cream',
                'image' => 'https://images.unsplash.com/photo-1550583724-b2692b85b150?w=500&q=80',
                'description' => '100% wholesome pasteurised cow milk enriched with natural calcium.'
            ],

            // Snacks & Tea
            [
                'id' => 'snack-1',
                'name' => 'Ispahani Mirzapore Best Tea (মির্জাপুর চা)',
                'bengali_name' => 'ইসপাহানি মির্জাপুর ব্ল্যাক টি',
                'category' => 'Snacks & Tea',
                'price' => 235,
                'old_price' => 250,
                'unit' => '400 g',
                'discount' => null,
                'badge' => 'Popular Choice',
                'image' => 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?w=500&q=80',
                'description' => 'Rich color and invigorating taste from Bangladesh finest Sylhet tea gardens.'
            ],
            [
                'id' => 'snack-2',
                'name' => 'Olympic Energy Plus Biscuit (এনার্জি প্লাস)',
                'bengali_name' => 'অলিম্পিক এনার্জি প্লাস বিস্কুট',
                'category' => 'Snacks & Tea',
                'price' => 45,
                'old_price' => 50,
                'unit' => '300 g Pack',
                'discount' => null,
                'badge' => 'Crisp Snack',
                'image' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=500&q=80',
                'description' => 'Classic crisp morning tea biscuit loved by Bangladeshi families.'
            ],
        ];
    }
}
