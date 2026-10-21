<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FreshDataSeeder extends Seeder
{
    /**
     * Saara purana data delete karo (Users chhod ke)
     * Phir har table mein 5-5 fresh records add karo
     */
    public function run(): void
    {
        // ─────────────────────────────────────────────────────────────
        // STEP 1: Foreign key checks disable (safe delete ke liye)
        // MySQL syntax
        // ─────────────────────────────────────────────────────────────
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // ─────────────────────────────────────────────────────────────
        // STEP 2: Saara data delete karo (users except)
        // ─────────────────────────────────────────────────────────────
        DB::table('post_dispatches')->truncate();
        DB::table('post_likes')->truncate();
        DB::table('post_views')->truncate();
        DB::table('post_tag')->truncate();
        DB::table('comments')->truncate();
        DB::table('subscribers')->truncate();
        DB::table('posts')->truncate();
        DB::table('tags')->truncate();
        DB::table('categories')->truncate();
        DB::table('settings')->truncate();

        // Foreign keys wapas on
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ─────────────────────────────────────────────────────────────
        // STEP 3: User ID fetch karo (existing user)
        // ─────────────────────────────────────────────────────────────
        $userId = DB::table('users')->value('id');

        $now = now();

        // ─────────────────────────────────────────────────────────────
        // STEP 4: Categories — 5 records
        // ─────────────────────────────────────────────────────────────
        DB::table('categories')->insert([
            ['name' => 'Web Development',   'slug' => 'web-development',   'description' => 'HTML, CSS, JS, PHP aur web technologies se related posts', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Laravel & PHP',      'slug' => 'laravel-php',       'description' => 'Laravel framework aur PHP best practices', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'JavaScript & React', 'slug' => 'javascript-react',  'description' => 'Modern JS, React, Vue aur frontend frameworks', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'DevOps & Tools',     'slug' => 'devops-tools',      'description' => 'Git, Docker, CI/CD aur developer tools', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Career & Tips',      'slug' => 'career-tips',       'description' => 'Developer career advice aur productivity tips', 'created_at' => $now, 'updated_at' => $now],
        ]);

        $catIds = DB::table('categories')->pluck('id')->toArray();

        // ─────────────────────────────────────────────────────────────
        // STEP 5: Tags — 5 records
        // ─────────────────────────────────────────────────────────────
        DB::table('tags')->insert([
            ['name' => 'Laravel',    'slug' => 'laravel',    'created_at' => $now, 'updated_at' => $now],
            ['name' => 'JavaScript', 'slug' => 'javascript', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'PHP',        'slug' => 'php',        'created_at' => $now, 'updated_at' => $now],
            ['name' => 'React',      'slug' => 'react',      'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Docker',     'slug' => 'docker',     'created_at' => $now, 'updated_at' => $now],
        ]);

        $tagIds = DB::table('tags')->pluck('id')->toArray();

        // ─────────────────────────────────────────────────────────────
        // STEP 6: Posts — 5 records
        // ─────────────────────────────────────────────────────────────
        DB::table('posts')->insert([
            [
                'user_id'     => $userId,
                'category_id' => $catIds[0],
                'title'       => 'Laravel 11 mein Naye Features — Complete Guide',
                'slug'        => 'laravel-11-naye-features-guide',
                'content'     => '<p>Laravel 11 kaafi exciting features lekar aaya hai. Is post mein hum Laravel 11 ke top features ko detail mein dekhenge.</p><h2>1. Streamlined Application Structure</h2><p>Laravel 11 ne default application structure ko bahut simplify kar diya hai.</p><h2>2. Health Routing</h2><p>Naya built-in health check route — /up — ab by default available hai.</p><h2>3. Model Casts as Methods</h2><p>Ab $casts ko method ke roop mein define kar sakte hain.</p>',
                'image'       => null,
                'status'      => 'published',
                'likes_count' => 42,
                'views_count' => 358,
                'created_at'  => now()->subDays(10),
                'updated_at'  => now()->subDays(10),
            ],
            [
                'user_id'     => $userId,
                'category_id' => $catIds[1],
                'title'       => 'Eloquent ORM — Advanced Relationships Tutorial',
                'slug'        => 'eloquent-orm-advanced-relationships',
                'content'     => '<p>Eloquent ORM Laravel ka sabse powerful feature hai. Is tutorial mein hum advanced relationships cover karenge.</p><h2>HasManyThrough</h2><p>Jab aapko kisi distant relation se data chahiye ho, hasManyThrough bahut useful hota hai.</p><h2>Polymorphic Relations</h2><p>Ek single model jo multiple doosre models se relate ho sake.</p>',
                'image'       => null,
                'status'      => 'published',
                'likes_count' => 28,
                'views_count' => 215,
                'created_at'  => now()->subDays(7),
                'updated_at'  => now()->subDays(7),
            ],
            [
                'user_id'     => $userId,
                'category_id' => $catIds[2],
                'title'       => 'React Hooks — useState aur useEffect Explained',
                'slug'        => 'react-hooks-usestate-useeffect-explained',
                'content'     => '<p>React Hooks ne class components ki zaroorat khatam kar di.</p><h2>useState Hook</h2><p>useState aapko functional components mein state add karne deta hai.</p><h2>useEffect Hook</h2><p>useEffect component ke side effects handle karta hai jaise API calls, subscriptions.</p>',
                'image'       => null,
                'status'      => 'published',
                'likes_count' => 65,
                'views_count' => 520,
                'created_at'  => now()->subDays(5),
                'updated_at'  => now()->subDays(5),
            ],
            [
                'user_id'     => $userId,
                'category_id' => $catIds[3],
                'title'       => 'Docker se Laravel App Deploy Karna — Step by Step',
                'slug'        => 'docker-laravel-app-deploy-step-by-step',
                'content'     => '<p>Docker ne modern DevOps ko bilkul badal diya hai.</p><h2>Dockerfile Banana</h2><p>Pehle hum apna custom PHP-FPM based Dockerfile banayenge.</p><h2>Docker Compose Setup</h2><p>Hum teen services chalayenge: app, nginx, aur mysql.</p>',
                'image'       => null,
                'status'      => 'published',
                'likes_count' => 33,
                'views_count' => 289,
                'created_at'  => now()->subDays(3),
                'updated_at'  => now()->subDays(3),
            ],
            [
                'user_id'     => $userId,
                'category_id' => $catIds[4],
                'title'       => 'Junior Developer se Senior Developer — Career Roadmap',
                'slug'        => 'junior-se-senior-developer-career-roadmap',
                'content'     => '<p>Web development mein career grow karna sirf code likhne se zyada hai.</p><h2>Technical Skills se Zyada</h2><p>Senior developers sirf code nahi likhte — wo system design karte hain.</p><h2>Open Source Contribution</h2><p>GitHub par open source projects mein contribute karna aapki visibility badhaata hai.</p>',
                'image'       => null,
                'status'      => 'draft',
                'likes_count' => 0,
                'views_count' => 0,
                'created_at'  => now()->subDays(1),
                'updated_at'  => now()->subDays(1),
            ],
        ]);

        $postIds = DB::table('posts')->pluck('id')->toArray();

        // ─────────────────────────────────────────────────────────────
        // STEP 7: Post-Tag Pivot — Har post ke 2-3 tags
        // ─────────────────────────────────────────────────────────────
        DB::table('post_tag')->insert([
            ['post_id' => $postIds[0], 'tag_id' => $tagIds[0]],
            ['post_id' => $postIds[0], 'tag_id' => $tagIds[2]],
            ['post_id' => $postIds[1], 'tag_id' => $tagIds[0]],
            ['post_id' => $postIds[1], 'tag_id' => $tagIds[2]],
            ['post_id' => $postIds[2], 'tag_id' => $tagIds[1]],
            ['post_id' => $postIds[2], 'tag_id' => $tagIds[3]],
            ['post_id' => $postIds[3], 'tag_id' => $tagIds[4]],
            ['post_id' => $postIds[4], 'tag_id' => $tagIds[0]],
            ['post_id' => $postIds[4], 'tag_id' => $tagIds[1]],
        ]);

        // ─────────────────────────────────────────────────────────────
        // STEP 8: Comments — 5 records
        // ─────────────────────────────────────────────────────────────
        DB::table('comments')->insert([
            [
                'post_id'      => $postIds[0],
                'name'         => 'Ahmed Khan',
                'email'        => 'ahmed.khan@example.com',
                'comment_body' => 'Bahut achhi post hai! Laravel 11 ki Health Routing feature mujhe nahi pata thi. Thanks for sharing.',
                'status'       => 'approved',
                'ip_address'   => '192.168.1.10',
                'user_agent'   => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'created_at'   => now()->subDays(9),
                'updated_at'   => now()->subDays(9),
            ],
            [
                'post_id'      => $postIds[0],
                'name'         => 'Priya Sharma',
                'email'        => 'priya.sharma@example.com',
                'comment_body' => 'Model Casts as Methods feature kaafi interesting hai. Iska ek practical example bhi add karo.',
                'status'       => 'approved',
                'ip_address'   => '203.0.113.25',
                'user_agent'   => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
                'created_at'   => now()->subDays(8),
                'updated_at'   => now()->subDays(8),
            ],
            [
                'post_id'      => $postIds[1],
                'name'         => 'Rahul Verma',
                'email'        => 'rahul.verma@example.com',
                'comment_body' => 'Polymorphic relations samajhna mushkil tha lekin aapne bahut clearly explain kiya. Shukriya!',
                'status'       => 'approved',
                'ip_address'   => '10.0.0.55',
                'user_agent'   => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36',
                'created_at'   => now()->subDays(6),
                'updated_at'   => now()->subDays(6),
            ],
            [
                'post_id'      => $postIds[2],
                'name'         => 'Sara Ali',
                'email'        => 'sara.ali@example.com',
                'comment_body' => 'useEffect dependency array ka concept ab clear ho gaya. Bahut helpful tutorial tha!',
                'status'       => 'approved',
                'ip_address'   => '172.16.0.100',
                'user_agent'   => 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X)',
                'created_at'   => now()->subDays(4),
                'updated_at'   => now()->subDays(4),
            ],
            [
                'post_id'      => $postIds[3],
                'name'         => 'Guest',
                'email'        => null,
                'comment_body' => 'Docker Compose wala section ekdum zabardast tha. Meri Laravel app ab Docker pe chal rahi hai!',
                'status'       => 'pending',
                'ip_address'   => '198.51.100.5',
                'user_agent'   => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Firefox/115.0',
                'created_at'   => now()->subDays(2),
                'updated_at'   => now()->subDays(2),
            ],
        ]);

        // ─────────────────────────────────────────────────────────────
        // STEP 9: Subscribers — 5 records
        // ─────────────────────────────────────────────────────────────
        DB::table('subscribers')->insert([
            ['email' => 'subscriber1@example.com',     'token' => Str::random(64), 'is_active' => true,  'created_at' => now()->subDays(30), 'updated_at' => now()->subDays(30)],
            ['email' => 'newsletter.fan@gmail.com',    'token' => Str::random(64), 'is_active' => true,  'created_at' => now()->subDays(20), 'updated_at' => now()->subDays(20)],
            ['email' => 'dev.reader@yahoo.com',        'token' => Str::random(64), 'is_active' => true,  'created_at' => now()->subDays(15), 'updated_at' => now()->subDays(15)],
            ['email' => 'tech.enthusiast@hotmail.com', 'token' => Str::random(64), 'is_active' => false, 'created_at' => now()->subDays(10), 'updated_at' => now()->subDays(5)],
            ['email' => 'coder.updates@proton.me',     'token' => Str::random(64), 'is_active' => true,  'created_at' => now()->subDays(3),  'updated_at' => now()->subDays(3)],
        ]);

        // ─────────────────────────────────────────────────────────────
        // STEP 10: Settings — 5 records
        // ─────────────────────────────────────────────────────────────
        DB::table('settings')->insert([
            ['key' => 'site_name',        'value' => 'My Personal Blog',                                                    'created_at' => $now, 'updated_at' => $now],
            ['key' => 'site_description', 'value' => 'Web development aur programming ki duniya mein aapka swagat hai',     'created_at' => $now, 'updated_at' => $now],
            ['key' => 'posts_per_page',   'value' => '10',                                                                  'created_at' => $now, 'updated_at' => $now],
            ['key' => 'allow_comments',   'value' => 'true',                                                                'created_at' => $now, 'updated_at' => $now],
            ['key' => 'footer_text',      'value' => '2026 Personal Blog. All rights reserved.',                            'created_at' => $now, 'updated_at' => $now],
        ]);

        // ─────────────────────────────────────────────────────────────
        // STEP 11: Post Views — 5 records
        // ─────────────────────────────────────────────────────────────
        DB::table('post_views')->insert([
            ['post_id' => $postIds[0], 'identifier_hash' => hash('sha256', '192.168.1.10|Mozilla Chrome'),   'viewed_at' => now()->subDays(9)],
            ['post_id' => $postIds[0], 'identifier_hash' => hash('sha256', '203.0.113.25|Safari Mac'),       'viewed_at' => now()->subDays(8)],
            ['post_id' => $postIds[1], 'identifier_hash' => hash('sha256', '10.0.0.55|Firefox Linux'),       'viewed_at' => now()->subDays(6)],
            ['post_id' => $postIds[2], 'identifier_hash' => hash('sha256', '172.16.0.100|Mobile Safari'),    'viewed_at' => now()->subDays(4)],
            ['post_id' => $postIds[3], 'identifier_hash' => hash('sha256', '198.51.100.5|Firefox Windows'),  'viewed_at' => now()->subDays(2)],
        ]);

        // ─────────────────────────────────────────────────────────────
        // STEP 12: Post Likes — 5 records
        // ─────────────────────────────────────────────────────────────
        DB::table('post_likes')->insert([
            ['post_id' => $postIds[0], 'identifier_hash' => hash('sha256', '192.168.1.10|Mozilla Chrome'),  'created_at' => now()->subDays(9)],
            ['post_id' => $postIds[1], 'identifier_hash' => hash('sha256', '203.0.113.25|Safari Mac'),      'created_at' => now()->subDays(7)],
            ['post_id' => $postIds[2], 'identifier_hash' => hash('sha256', '10.0.0.55|Firefox Linux'),      'created_at' => now()->subDays(5)],
            ['post_id' => $postIds[2], 'identifier_hash' => hash('sha256', '172.16.0.100|Mobile Safari'),   'created_at' => now()->subDays(4)],
            ['post_id' => $postIds[3], 'identifier_hash' => hash('sha256', '198.51.100.5|Firefox Windows'), 'created_at' => now()->subDays(2)],
        ]);

        // ─────────────────────────────────────────────────────────────
        // STEP 13: Post Dispatches — 5 records
        // ─────────────────────────────────────────────────────────────
        $subscriberIds = DB::table('subscribers')->pluck('id')->toArray();

        DB::table('post_dispatches')->insert([
            ['post_id' => $postIds[0], 'subscriber_id' => $subscriberIds[0], 'status' => 'sent',    'sent_at' => now()->subDays(9), 'error_message' => null,                     'created_at' => now()->subDays(9), 'updated_at' => now()->subDays(9)],
            ['post_id' => $postIds[0], 'subscriber_id' => $subscriberIds[1], 'status' => 'sent',    'sent_at' => now()->subDays(9), 'error_message' => null,                     'created_at' => now()->subDays(9), 'updated_at' => now()->subDays(9)],
            ['post_id' => $postIds[1], 'subscriber_id' => $subscriberIds[0], 'status' => 'sent',    'sent_at' => now()->subDays(7), 'error_message' => null,                     'created_at' => now()->subDays(7), 'updated_at' => now()->subDays(7)],
            ['post_id' => $postIds[2], 'subscriber_id' => $subscriberIds[2], 'status' => 'failed',  'sent_at' => null,              'error_message' => 'SMTP connection timeout', 'created_at' => now()->subDays(5), 'updated_at' => now()->subDays(5)],
            ['post_id' => $postIds[3], 'subscriber_id' => $subscriberIds[4], 'status' => 'pending', 'sent_at' => null,              'error_message' => null,                     'created_at' => now()->subDays(2), 'updated_at' => now()->subDays(2)],
        ]);

        $this->command->info('');
        $this->command->info('✅ Purana data delete ho gaya (users safe hain)');
        $this->command->info('✅ 5 Categories insert ho gayi');
        $this->command->info('✅ 5 Tags insert ho gaye');
        $this->command->info('✅ 5 Posts insert ho gaye (4 published, 1 draft)');
        $this->command->info('✅ 5 Comments insert ho gayi (4 approved, 1 pending)');
        $this->command->info('✅ 5 Subscribers insert ho gaye (4 active, 1 inactive)');
        $this->command->info('✅ 5 Settings insert ho gayi');
        $this->command->info('✅ 5 Post Views insert ho gayi');
        $this->command->info('✅ 5 Post Likes insert ho gaye');
        $this->command->info('✅ 5 Post Dispatches insert ho gaye');
        $this->command->info('🎉 Fresh data seeding complete!');
    }
}
