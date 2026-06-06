<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SellerProfile;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin PenBox',
            'email' => 'admin@penbox.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Seller
        $seller = User::create([
            'name' => 'Ahmad Faris',
            'email' => 'seller@penbox.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'phone' => '0123456789',
            'address' => 'No. 12, Jalan Utama, Kuala Lumpur',
            'is_active' => true,
        ]);

        SellerProfile::create([
            'user_id' => $seller->id,
            'shop_name' => 'PenBox Official Store',
            'shop_description' => 'Your one-stop stationery shop! We provide high-quality pens, notebooks, art supplies and more.',
            'bank_name' => 'Maybank',
            'bank_account' => '1234567890',
            'status' => 'approved',
        ]);

        // User
        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'user@penbox.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '0198765432',
            'address' => 'No. 5, Jalan Damai, Petaling Jaya',
            'is_active' => true,
        ]);

        // Categories
        $cats = [
            ['name' => 'Pens & Pencils', 'slug' => 'pens-pencils', 'icon' => '✏️'],
            ['name' => 'Notebooks', 'slug' => 'notebooks', 'icon' => '📓'],
            ['name' => 'Art Supplies', 'slug' => 'art-supplies', 'icon' => '🎨'],
            ['name' => 'Office Supplies', 'slug' => 'office-supplies', 'icon' => '📎'],
            ['name' => 'Bags & Cases', 'slug' => 'bags-cases', 'icon' => '🎒'],
        ];

        $categoryIds = [];
        foreach ($cats as $cat) {
            $c = Category::create($cat);
            $categoryIds[$cat['slug']] = $c->id;
        }

        // Products (10+ stationery items)
        $products = [
            [
                'name' => 'Pilot G2 Gel Pen (Black) – 10 Pack',
                'description' => 'The Pilot G2 is a fan-favourite retractable gel pen with a smooth-rolling refillable ink cartridge. Features comfortable rubber grip and comes in a value 10-pack. Perfect for students and office workers alike.',
                'price' => 18.90,
                'stock' => 150,
                'category' => 'pens-pencils',
                'image' => 'https://placehold.co/400x400/6366f1/white?text=G2+Gel+Pen',
            ],
            [
                'name' => 'Staedtler Noris Colour Pencils 24-Set',
                'description' => 'Vibrant 24-colour pencil set by Staedtler, perfect for colouring, sketching and school projects. Break-resistant bonded lead with smooth colour laydown. Hexagonal barrel for comfortable grip.',
                'price' => 22.50,
                'stock' => 80,
                'category' => 'pens-pencils',
                'image' => 'https://placehold.co/400x400/ec4899/white?text=Colour+Pencils',
            ],
            [
                'name' => 'Muji A5 Hardcover Notebook – Dotted',
                'description' => 'Premium A5 hardcover notebook with 80gsm dotted pages. 192 pages total with lay-flat binding. Ideal for bullet journalling, note-taking and sketching. Clean minimalist design.',
                'price' => 35.00,
                'stock' => 60,
                'category' => 'notebooks',
                'image' => 'https://placehold.co/400x400/14b8a6/white?text=Dotted+Notebook',
            ],
            [
                'name' => 'Leuchtturm1917 B5 Ruled Notebook',
                'description' => 'German-engineered notebook with 251 numbered pages, 2 bookmarks, pocket at the back and sticker set. 80gsm ink-proof paper. Beloved by students, writers and professionals worldwide.',
                'price' => 65.00,
                'stock' => 40,
                'category' => 'notebooks',
                'image' => 'https://placehold.co/400x400/f59e0b/white?text=Leuchtturm+B5',
            ],
            [
                'name' => 'Sakura Pigma Micron Fineliner Set (6 pcs)',
                'description' => 'Archival-quality pigment ink fineliners in 6 tip sizes (0.20mm–0.50mm). Water-resistant, fade-proof ink perfect for technical drawing, manga art, and detailed illustrations.',
                'price' => 42.00,
                'stock' => 55,
                'category' => 'art-supplies',
                'image' => 'https://placehold.co/400x400/8b5cf6/white?text=Micron+Fineliners',
            ],
            [
                'name' => 'Winsor & Newton Watercolour Set 12 Pan',
                'description' => 'Professional-grade travel watercolour set with 12 vibrant pans, mixing palette and a water brush. Compact design ideal for outdoor sketching and plein air painting.',
                'price' => 89.90,
                'stock' => 25,
                'category' => 'art-supplies',
                'image' => 'https://placehold.co/400x400/ef4444/white?text=Watercolour+Set',
            ],
            [
                'name' => 'Kokuyo Campus Loose Leaf Binder A4',
                'description' => 'High-quality A4 ring binder with 26-ring mechanism. Fits up to 200 sheets. Durable PP cover with clear front pocket. Available in multiple pastel colours. Great for school and university.',
                'price' => 28.00,
                'stock' => 70,
                'category' => 'office-supplies',
                'image' => 'https://placehold.co/400x400/3b82f6/white?text=Ring+Binder',
            ],
            [
                'name' => 'Post-it Super Sticky Notes 3×3 (12 Pads)',
                'description' => 'Super sticky adhesive notes that stay put and remove cleanly without damaging surfaces. 12 pads of 90 sheets each in assorted bright colours. Ideal for reminders, brainstorming and task management.',
                'price' => 32.00,
                'stock' => 100,
                'category' => 'office-supplies',
                'image' => 'https://placehold.co/400x400/f97316/white?text=Sticky+Notes',
            ],
            [
                'name' => 'Maped Helix Maths Geometry Set',
                'description' => 'Complete 8-piece geometry set including compass, protractor, ruler, set squares and more. Precision-engineered metal and plastic tools in a durable zip case. Essential for maths students.',
                'price' => 15.50,
                'stock' => 90,
                'category' => 'office-supplies',
                'image' => 'https://placehold.co/400x400/10b981/white?text=Geometry+Set',
            ],
            [
                'name' => 'Smiggle Zip Around Pencil Case',
                'description' => 'Large-capacity zip-around pencil case with multiple compartments. Can hold 50+ stationery items. Bright neon design with durable polyester outer. Perfect for primary and secondary school students.',
                'price' => 45.00,
                'stock' => 35,
                'category' => 'bags-cases',
                'image' => 'https://placehold.co/400x400/d946ef/white?text=Pencil+Case',
            ],
            [
                'name' => 'Zebra Mildliner Highlighter Set (20 colours)',
                'description' => 'Cult-favourite Japanese dual-tip highlighters with mild, eye-friendly ink colours. Each pen features a broad chisel tip and fine bullet tip. 20-colour set covering warm, cool and fluorescent tones.',
                'price' => 68.00,
                'stock' => 50,
                'category' => 'pens-pencils',
                'image' => 'https://placehold.co/400x400/a855f7/white?text=Mildliner+Set',
            ],
            [
                'name' => 'Faber-Castell Grip Mechanical Pencil 0.5mm',
                'description' => 'Award-winning mechanical pencil with patented SoftGrip zone of small raised dots for fatigue-free writing. PVC-free grip, push-top eraser, and windowed lead storage. 0.5mm HB lead included.',
                'price' => 12.90,
                'stock' => 120,
                'category' => 'pens-pencils',
                'image' => 'https://placehold.co/400x400/06b6d4/white?text=Mech+Pencil',
            ],
        ];

        foreach ($products as $p) {
            Product::create([
                'seller_id' => $seller->id,
                'category_id' => $categoryIds[$p['category']] ?? null,
                'name' => $p['name'],
                'slug' => Str::slug($p['name']) . '-' . Str::random(4),
                'description' => $p['description'],
                'price' => $p['price'],
                'stock' => $p['stock'],
                'image' => $p['image'],
                'is_active' => true,
            ]);
        }

        $this->command->info('✅ Seeded: 1 Admin, 1 Seller, 1 User, 5 Categories, 12 Products');
    }
}
