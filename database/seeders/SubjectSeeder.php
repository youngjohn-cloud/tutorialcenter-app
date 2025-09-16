<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Str;
use Faker\Factory as Faker;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [

            // ================= JAMB =================
            [
                "name" => "Use of English",
                "slug" => "utme-use-of-english",
                "description" => "Tests proficiency in English grammar, comprehension, and vocabulary.",
                "courses_ids" => [1],
                "departments" => ['science', 'art', 'commercial'],
            ],
            [
                "name" => "Mathematics",
                "slug" => "utme-mathematics",
                "description" => "Focuses on arithmetic, algebra, geometry, and quantitative reasoning.",
                "courses_ids" => [1],
                "departments" => ['science', 'commercial'],
            ],
            [
                "name" => "Physics",
                "slug" => "utme-physics",
                "description" => "Covers mechanics, electricity, waves, and modern physics.",
                "courses_ids" => [1],
                "departments" => ['science'],
            ],
            [
                "name" => "Chemistry",
                "slug" => "utme-chemistry",
                "description" => "Tests knowledge of organic, inorganic, and physical chemistry.",
                "courses_ids" => [1],
                "departments" => ['science'],
            ],
            [
                "name" => "Biology",
                "slug" => "utme-biology",
                "description" => "Covers ecology, genetics, physiology, and cell biology.",
                "courses_ids" => [1],
                "departments" => ['science'],
            ],
            [
                "name" => "Economics",
                "slug" => "utme-economics",
                "description" => "Covers microeconomics, macroeconomics, and economic principles.",
                "courses_ids" => [1],
                "departments" => ['art', 'commercial'],
            ],
            [
                "name" => "Government",
                "slug" => "utme-government",
                "description" => "Focuses on political science, constitutions, and governance.",
                "courses_ids" => [1],
                "departments" => ['art', 'commercial'],
            ],
            [
                "name" => "Literature in English",
                "slug" => "utme-literature-in-english",
                "description" => "Tests knowledge of poetry, prose, and drama.",
                "courses_ids" => [1],
                "departments" => ['art'],
            ],
            [
                "name" => "Christian Religious Studies (CRS)",
                "slug" => "utme-crs",
                "description" => "Covers the Bible, Christian doctrines, and values.",
                "courses_ids" => [1],
                "departments" => ['art'],
            ],
            [
                "name" => "Islamic Religious Studies",
                "slug" => "irs",
                "description" => "Covers the Quran, Hadith, and Islamic history.",
                "courses_ids" => [1],
                "departments" => ['art'],
            ],
            [
                "name" => "Geography",
                "slug" => "utme-geography",
                "description" => "Tests knowledge of physical and human geography.",
                "courses_ids" => [1],
                "departments" => ['science', 'art', 'commercial'],
            ],
            [
                "name" => "Commerce",
                "slug" => "utme-commerce",
                "description" => "Covers trade, business, and financial principles.",
                "courses_ids" => [1],
                "departments" => ['commercial'],
            ],
            [
                "name" => "Accounting",
                "slug" => "utme-accounting",
                "description" => "Covers bookkeeping, principles of accounts, and auditing.",
                "courses_ids" => [1],
                "departments" => ['commercial'],
            ],
            [
                "name" => "Agricultural Science",
                "slug" => "utme-agricultural-science",
                "description" => "Covers farming, animal husbandry, and crop science.",
                "courses_ids" => [1],
                "departments" => ['science'],
            ],
            [
                "name" => "History",
                "slug" => "utme-history",
                "description" => "Focuses on Nigerian and world history.",
                "courses_ids" => [1],
                "departments" => ['art'],
            ],
            [
                "name" => "Fine Arts",
                "slug" => "utme-fine-arts",
                "description" => "Tests creativity in drawing, painting, and design.",
                "courses_ids" => [1],
                "departments" => ['art'],
            ],
            [
                "name" => "Music",
                "slug" => "utme-music",
                "description" => "Covers music theory, history, and performance.",
                "courses_ids" => [1],
                "departments" => ['art'],
            ],

            // ================= WAEC + GCE =================
            [
                "name" => "English Language",
                "slug" => "ssce-english-language",
                "description" => "Tests grammar, comprehension, and essay writing.",
                "courses_ids" => [2, 4],
                "departments" => ['science', 'art', 'commercial'],
            ],
            [
                "name" => "Mathematics",
                "slug" => "ssce-mathematics",
                "description" => "Focuses on algebra, statistics, geometry, and calculus.",
                "courses_ids" => [2, 4],
                "departments" => ['science', 'commercial'],
            ],
            [
                "name" => "Biology",
                "slug" => "ssce-biology",
                "description" => "Covers genetics, ecology, and physiology.",
                "courses_ids" => [2, 4],
                "departments" => ['science'],
            ],
            [
                "name" => "Chemistry",
                "slug" => "ssce-chemistry",
                "description" => "Tests inorganic, organic, and physical chemistry.",
                "courses_ids" => [2, 4],
                "departments" => ['science'],
            ],
            [
                "name" => "Physics",
                "slug" => "ssce-physics",
                "description" => "Covers mechanics, waves, electricity, and nuclear physics.",
                "courses_ids" => [2, 4],
                "departments" => ['science'],
            ],
            [
                "name" => "Geography",
                "slug" => "ssce-geography",
                "description" => "Covers physical, human, and regional geography.",
                "courses_ids" => [2, 4],
                "departments" => ['science', 'art', 'commercial'],
            ],
            [
                "name" => "Economics",
                "slug" => "ssce-economics",
                "description" => "Covers trade, finance, and economics principles.",
                "courses_ids" => [2, 4],
                "departments" => ['art', 'commercial'],
            ],
            [
                "name" => "Government",
                "slug" => "ssce-government",
                "description" => "Covers constitutions, politics, and governance.",
                "courses_ids" => [2, 4],
                "departments" => ['art', 'commercial'],
            ],
            [
                "name" => "Literature in English",
                "slug" => "ssce-literature-in-english",
                "description" => "Tests prose, poetry, and drama analysis.",
                "courses_ids" => [2, 4],
                "departments" => ['art'],
            ],
            [
                "name" => "Agricultural Science",
                "slug" => "ssce-agricultural-science",
                "description" => "Covers crops, livestock, and soil management.",
                "courses_ids" => [2, 4],
                "departments" => ['science'],
            ],
            [
                "name" => "Accounting",
                "slug" => "ssce-accounting",
                "description" => "Covers bookkeeping, financial accounting, and auditing.",
                "courses_ids" => [2, 4],
                "departments" => ['commercial'],
            ],
            [
                "name" => "Commerce",
                "slug" => "ssce-commerce",
                "description" => "Focuses on trade, entrepreneurship, and marketing.",
                "courses_ids" => [2, 4],
                "departments" => ['commercial'],
            ],
            [
                "name" => "History",
                "slug" => "ssce-history",
                "description" => "Covers Nigerian and world history.",
                "courses_ids" => [2, 4],
                "departments" => ['art'],
            ],
            [
                "name" => "Civic Education",
                "slug" => "ssce-civic-education",
                "description" => "Tests knowledge of rights, duties, and citizenship.",
                "courses_ids" => [2, 4],
                "departments" => ['science', 'art', 'commercial'],
            ],
            [
                "name" => "Christian Religious Studies (CRS)",
                "slug" => "ssce-crs",
                "description" => "Covers Bible studies, Christian faith, and morality.",
                "courses_ids" => [2, 4],
                "departments" => ['art'],
            ],
            [
                "name" => "Islamic Studies",
                "slug" => "ssce-irs",
                "description" => "Covers the Quran, Hadith, and Islamic history.",
                "courses_ids" => [2, 4],
                "departments" => ['art'],
            ],
            [
                "name" => "Fine Arts",
                "slug" => "ssce-fine-arts",
                "description" => "Covers drawing, painting, and sculpture.",
                "courses_ids" => [2, 4],
                "departments" => ['art'],
            ],
            [
                "name" => "Music",
                "slug" => "ssce-music",
                "description" => "Covers music theory, culture, and practice.",
                "courses_ids" => [2, 4],
                "departments" => ['art'],
            ],

            // ================= NECO =================
            [
                "name" => "English Language",
                "slug" => "neco-english-language",
                "description" => "Tests comprehension, essay writing, and grammar.",
                "courses_ids" => [3],
                "departments" => ['science', 'art', 'commercial'],
            ],
            [
                "name" => "Mathematics",
                "slug" => "neco-mathematics",
                "description" => "Focuses on trigonometry, algebra, and calculus.",
                "courses_ids" => [3],
                "departments" => ['science', 'commercial'],
            ],
            [
                "name" => "Biology",
                "slug" => "neco-biology",
                "description" => "Covers cell biology, genetics, and ecology.",
                "courses_ids" => [3],
                "departments" => ['science'],
            ],
            [
                "name" => "Chemistry",
                "slug" => "neco-chemistry",
                "description" => "Covers organic, inorganic, and physical chemistry.",
                "courses_ids" => [3],
                "departments" => ['science'],
            ],
            [
                "name" => "Physics",
                "slug" => "neco-physics",
                "description" => "Tests knowledge of motion, heat, electricity, and waves.",
                "courses_ids" => [3],
                "departments" => ['science'],
            ],
            [
                "name" => "Geography",
                "slug" => "neco-geography",
                "description" => "Covers maps, landforms, and population studies.",
                "courses_ids" => [3],
                "departments" => ['science', 'art', 'commercial'],
            ],
            [
                "name" => "Economics",
                "slug" => "neco-economics",
                "description" => "Covers demand, supply, and national income.",
                "courses_ids" => [3],
                "departments" => ['art', 'commercial'],
            ],
            [
                "name" => "Government",
                "slug" => "neco-government",
                "description" => "Covers politics, democracy, and constitutions.",
                "courses_ids" => [3],
                "departments" => ['art', 'commercial'],
            ],
            [
                "name" => "Literature in English",
                "slug" => "neco-literature-in-english",
                "description" => "Covers African and non-African prose, poetry, and drama.",
                "courses_ids" => [3],
                "departments" => ['art'],
            ],
            [
                "name" => "Agricultural Science",
                "slug" => "neco-agricultural-science",
                "description" => "Covers animal and crop farming techniques.",
                "courses_ids" => [3],
                "departments" => ['science'],
            ],
            [
                "name" => "Accounting",
                "slug" => "neco-accounting",
                "description" => "Covers double-entry principles, accounts, and auditing.",
                "courses_ids" => [3],
                "departments" => ['commercial'],
            ],
            [
                "name" => "Commerce",
                "slug" => "neco-commerce",
                "description" => "Covers production, business, and trade systems.",
                "courses_ids" => [3],
                "departments" => ['commercial'],
            ],
            [
                "name" => "History",
                "slug" => "neco-history",
                "description" => "Covers Nigerian history and world civilizations.",
                "courses_ids" => [3],
                "departments" => ['art'],
            ],
            [
                "name" => "Civic Education",
                "slug" => "neco-civic-education",
                "description" => "Covers civic rights, values, and national development.",
                "courses_ids" => [3],
                "departments" => ['science', 'art', 'commercial'],
            ],
            [
                "name" => "Christian Religious Studies (CRS)",
                "slug" => "neco-crs",
                "description" => "Covers Christian beliefs and biblical principles.",
                "courses_ids" => [3],
                "departments" => ['art'],
            ],
            [
                "name" => "Islamic Studies",
                "slug" => "neco-irs",
                "description" => "Covers Islamic beliefs, laws, and practices.",
                "courses_ids" => [3],
                "departments" => ['art'],
            ],
            [
                "name" => "Fine Arts",
                "slug" => "neco-fine-arts",
                "description" => "Covers creative arts and practical designs.",
                "courses_ids" => [3],
                "departments" => ['art'],
            ],
            [
                "name" => "Music",
                "slug" => "neco-music",
                "description" => "Covers rhythm, melody, and cultural music studies.",
                "courses_ids" => [3],
                "departments" => ['art'],
            ],
        ];

        $faker = Faker::create();


        foreach ($subjects as $subject) {
            Subject::create([
                'name' => $subject['name'],
                'slug' => Str::slug($subject['slug']),
                'description' => $subject['description'],
                'courses_ids' => json_encode($subject['courses_ids']),
                'departments' => json_encode($subject['departments']),
                'created_by' => 1,
                'status' => 'published'
            ]);
        }
    }
}
