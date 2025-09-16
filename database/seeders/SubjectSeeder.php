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
                "description" => "Tests proficiency in English grammar, comprehension, and vocabulary.",
                "courses_ids" => [1],
                "departments" => ["science", "art", "commercial"],
            ],
            [
                "name" => "Mathematics",
                "description" => "Focuses on arithmetic, algebra, geometry, and quantitative reasoning.",
                "courses_ids" => [1],
                "departments" => ["science", "commercial"],
            ],
            [
                "name" => "Physics",
                "description" => "Covers mechanics, electricity, waves, and modern physics.",
                "courses_ids" => [1],
                "departments" => ["science"],
            ],
            [
                "name" => "Chemistry",
                "description" => "Tests knowledge of organic, inorganic, and physical chemistry.",
                "courses_ids" => [1],
                "departments" => ["science"],
            ],
            [
                "name" => "Biology",
                "description" => "Covers ecology, genetics, physiology, and cell biology.",
                "courses_ids" => [1],
                "departments" => ["science"],
            ],
            [
                "name" => "Economics",
                "description" => "Covers microeconomics, macroeconomics, and economic principles.",
                "courses_ids" => [1],
                "departments" => ["art", "commercial"],
            ],
            [
                "name" => "Government",
                "description" => "Focuses on political science, constitutions, and governance.",
                "courses_ids" => [1],
                "departments" => ["art", "commercial"],
            ],
            [
                "name" => "Literature in English",
                "description" => "Tests knowledge of poetry, prose, and drama.",
                "courses_ids" => [1],
                "departments" => ["art"],
            ],
            [
                "name" => "Christian Religious Studies (CRS)",
                "description" => "Covers the Bible, Christian doctrines, and values.",
                "courses_ids" => [1],
                "departments" => ["art"],
            ],
            [
                "name" => "Islamic Studies",
                "description" => "Covers the Quran, Hadith, and Islamic history.",
                "courses_ids" => [1],
                "departments" => ["art"],
            ],
            [
                "name" => "Geography",
                "description" => "Tests knowledge of physical and human geography.",
                "courses_ids" => [1],
                "departments" => ["science", "art", "commercial"],
            ],
            [
                "name" => "Commerce",
                "description" => "Covers trade, business, and financial principles.",
                "courses_ids" => [1],
                "departments" => ["commercial"],
            ],
            [
                "name" => "Accounting",
                "description" => "Covers bookkeeping, principles of accounts, and auditing.",
                "courses_ids" => [1],
                "departments" => ["commercial"],
            ],
            [
                "name" => "Agricultural Science",
                "description" => "Covers farming, animal husbandry, and crop science.",
                "courses_ids" => [1],
                "departments" => ["science"],
            ],
            [
                "name" => "History",
                "description" => "Focuses on Nigerian and world history.",
                "courses_ids" => [1],
                "departments" => ["art"],
            ],
            [
                "name" => "Fine Arts",
                "description" => "Tests creativity in drawing, painting, and design.",
                "courses_ids" => [1],
                "departments" => ["art"],
            ],
            [
                "name" => "Music",
                "description" => "Covers music theory, history, and performance.",
                "courses_ids" => [1],
                "departments" => ["art"],
            ],

            // ================= WAEC + GCE =================
            [
                "name" => "English Language",
                "description" => "Tests grammar, comprehension, and essay writing.",
                "courses_ids" => [2, 4],
                "departments" => ["science", "art", "commercial"],
            ],
            [
                "name" => "Mathematics",
                "description" => "Focuses on algebra, statistics, geometry, and calculus.",
                "courses_ids" => [2, 4],
                "departments" => ["science", "commercial"],
            ],
            [
                "name" => "Biology",
                "description" => "Covers genetics, ecology, and physiology.",
                "courses_ids" => [2, 4],
                "departments" => ["science"],
            ],
            [
                "name" => "Chemistry",
                "description" => "Tests inorganic, organic, and physical chemistry.",
                "courses_ids" => [2, 4],
                "departments" => ["science"],
            ],
            [
                "name" => "Physics",
                "description" => "Covers mechanics, waves, electricity, and nuclear physics.",
                "courses_ids" => [2, 4],
                "departments" => ["science"],
            ],
            [
                "name" => "Geography",
                "description" => "Covers physical, human, and regional geography.",
                "courses_ids" => [2, 4],
                "departments" => ["science", "art", "commercial"],
            ],
            [
                "name" => "Economics",
                "description" => "Covers trade, finance, and economics principles.",
                "courses_ids" => [2, 4],
                "departments" => ["art", "commercial"],
            ],
            [
                "name" => "Government",
                "description" => "Covers constitutions, politics, and governance.",
                "courses_ids" => [2, 4],
                "departments" => ["art", "commercial"],
            ],
            [
                "name" => "Literature in English",
                "description" => "Tests prose, poetry, and drama analysis.",
                "courses_ids" => [2, 4],
                "departments" => ["art"],
            ],
            [
                "name" => "Agricultural Science",
                "description" => "Covers crops, livestock, and soil management.",
                "courses_ids" => [2, 4],
                "departments" => ["science"],
            ],
            [
                "name" => "Accounting",
                "description" => "Covers bookkeeping, financial accounting, and auditing.",
                "courses_ids" => [2, 4],
                "departments" => ["commercial"],
            ],
            [
                "name" => "Commerce",
                "description" => "Focuses on trade, entrepreneurship, and marketing.",
                "courses_ids" => [2, 4],
                "departments" => ["commercial"],
            ],
            [
                "name" => "History",
                "description" => "Covers Nigerian and world history.",
                "courses_ids" => [2, 4],
                "departments" => ["art"],
            ],
            [
                "name" => "Civic Education",
                "description" => "Tests knowledge of rights, duties, and citizenship.",
                "courses_ids" => [2, 4],
                "departments" => ["science", "art", "commercial"],
            ],
            [
                "name" => "Christian Religious Studies (CRS)",
                "description" => "Covers Bible studies, Christian faith, and morality.",
                "courses_ids" => [2, 4],
                "departments" => ["art"],
            ],
            [
                "name" => "Islamic Studies",
                "description" => "Covers the Quran, Hadith, and Islamic history.",
                "courses_ids" => [2, 4],
                "departments" => ["art"],
            ],
            [
                "name" => "Fine Arts",
                "description" => "Covers drawing, painting, and sculpture.",
                "courses_ids" => [2, 4],
                "departments" => ["art"],
            ],
            [
                "name" => "Music",
                "description" => "Covers music theory, culture, and practice.",
                "courses_ids" => [2, 4],
                "departments" => ["art"],
            ],

            // ================= NECO =================
            [
                "name" => "English Language",
                "description" => "Tests comprehension, essay writing, and grammar.",
                "courses_ids" => [3],
                "departments" => ["science", "art", "commercial"],
            ],
            [
                "name" => "Mathematics",
                "description" => "Focuses on trigonometry, algebra, and calculus.",
                "courses_ids" => [3],
                "departments" => ["science", "commercial"],
            ],
            [
                "name" => "Biology",
                "description" => "Covers cell biology, genetics, and ecology.",
                "courses_ids" => [3],
                "departments" => ["science"],
            ],
            [
                "name" => "Chemistry",
                "description" => "Covers organic, inorganic, and physical chemistry.",
                "courses_ids" => [3],
                "departments" => ["science"],
            ],
            [
                "name" => "Physics",
                "description" => "Tests knowledge of motion, heat, electricity, and waves.",
                "courses_ids" => [3],
                "departments" => ["science"],
            ],
            [
                "name" => "Geography",
                "description" => "Covers maps, landforms, and population studies.",
                "courses_ids" => [3],
                "departments" => ["science", "art", "commercial"],
            ],
            [
                "name" => "Economics",
                "description" => "Covers demand, supply, and national income.",
                "courses_ids" => [3],
                "departments" => ["art", "commercial"],
            ],
            [
                "name" => "Government",
                "description" => "Covers politics, democracy, and constitutions.",
                "courses_ids" => [3],
                "departments" => ["art", "commercial"],
            ],
            [
                "name" => "Literature in English",
                "description" => "Covers African and non-African prose, poetry, and drama.",
                "courses_ids" => [3],
                "departments" => ["art"],
            ],
            [
                "name" => "Agricultural Science",
                "description" => "Covers animal and crop farming techniques.",
                "courses_ids" => [3],
                "departments" => ["science"],
            ],
            [
                "name" => "Accounting",
                "description" => "Covers double-entry principles, accounts, and auditing.",
                "courses_ids" => [3],
                "departments" => ["commercial"],
            ],
            [
                "name" => "Commerce",
                "description" => "Covers production, business, and trade systems.",
                "courses_ids" => [3],
                "departments" => ["commercial"],
            ],
            [
                "name" => "History",
                "description" => "Covers Nigerian history and world civilizations.",
                "courses_ids" => [3],
                "departments" => ["art"],
            ],
            [
                "name" => "Civic Education",
                "description" => "Covers civic rights, values, and national development.",
                "courses_ids" => [3],
                "departments" => ["science", "art", "commercial"],
            ],
            [
                "name" => "Christian Religious Studies (CRS)",
                "description" => "Covers Christian beliefs and biblical principles.",
                "courses_ids" => [3],
                "departments" => ["art"],
            ],
            [
                "name" => "Islamic Studies",
                "description" => "Covers Islamic beliefs, laws, and practices.",
                "courses_ids" => [3],
                "departments" => ["art"],
            ],
            [
                "name" => "Fine Arts",
                "description" => "Covers creative arts and practical designs.",
                "courses_ids" => [3],
                "departments" => ["art"],
            ],
            [
                "name" => "Music",
                "description" => "Covers rhythm, melody, and cultural music studies.",
                "courses_ids" => [3],
                "departments" => ["art"],
            ],
        ];

        $faker = Faker::create();


        foreach ($subjects as $subject) {
            Subject::create([
                'name' => $subject['name'],
                'slug' => Str::slug($faker->unique()->word()),
                'description' => $subject['description'],
                'courses_ids' => json_encode($subject['courses_ids']),
                'departments' => json_encode($subject['departments']),
                'created_by' => rand(1,10),
                'status' => 'published'
            ]);
        }
    }
}
