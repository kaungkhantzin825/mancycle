<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            // Yangon Region
            [
                'name' => 'Yangon Region',
                'name_mm' => 'ရန်ကုန်တိုင်းဒေသကြီး',
                'type' => 'region',
                'children' => [
                    [
                        'name' => 'Yangon',
                        'name_mm' => 'ရန်ကုန်',
                        'type' => 'city',
                        'children' => [
                            ['name' => 'Insein', 'name_mm' => 'အင်းစိန်', 'type' => 'township'],
                            ['name' => 'Hlaing', 'name_mm' => 'လှိုင်', 'type' => 'township'],
                            ['name' => 'Kamayut', 'name_mm' => 'ကမာရွတ်', 'type' => 'township'],
                            ['name' => 'Mayangone', 'name_mm' => 'မရမ်းကုန်း', 'type' => 'township'],
                            ['name' => 'Sanchaung', 'name_mm' => 'စမ်းချောင်း', 'type' => 'township'],
                            ['name' => 'Bahan', 'name_mm' => 'ဗဟန်း', 'type' => 'township'],
                            ['name' => 'Dagon', 'name_mm' => 'ဒဂုံ', 'type' => 'township'],
                            ['name' => 'South Okkalapa', 'name_mm' => 'တောင်ဥက္ကလာပ', 'type' => 'township'],
                            ['name' => 'North Okkalapa', 'name_mm' => 'မြောက်ဥက္ကလာပ', 'type' => 'township'],
                            ['name' => 'Thaketa', 'name_mm' => 'သာကေတ', 'type' => 'township'],
                            ['name' => 'Thingangyun', 'name_mm' => 'သင်္ဃန်းကျွန်း', 'type' => 'township'],
                            ['name' => 'Tamwe', 'name_mm' => 'တာမွေ', 'type' => 'township'],
                            ['name' => 'Yankin', 'name_mm' => 'ရန်ကင်း', 'type' => 'township'],
                            ['name' => 'Mingaladon', 'name_mm' => 'မင်္ဂလာဒုံ', 'type' => 'township'],
                            ['name' => 'Hlaingthaya', 'name_mm' => 'လှိုင်သာယာ', 'type' => 'township'],
                            ['name' => 'Shwepyitha', 'name_mm' => 'ရွှေပြည်သာ', 'type' => 'township'],
                        ]
                    ]
                ]
            ],
            // Mandalay Region
            [
                'name' => 'Mandalay Region',
                'name_mm' => 'မန္တလေးတိုင်းဒေသကြီး',
                'type' => 'region',
                'children' => [
                    [
                        'name' => 'Mandalay',
                        'name_mm' => 'မန္တလေး',
                        'type' => 'city',
                        'children' => [
                            ['name' => 'Aungmyethazan', 'name_mm' => 'အောင်မြေသာစံ', 'type' => 'township'],
                            ['name' => 'Chanayethazan', 'name_mm' => 'ချမ်းအေးသာစံ', 'type' => 'township'],
                            ['name' => 'Chanmyathazi', 'name_mm' => 'ချမ်းမြသာစည်', 'type' => 'township'],
                            ['name' => 'Maha Aungmye', 'name_mm' => 'မဟာအောင်မြေ', 'type' => 'township'],
                            ['name' => 'Patheingyi', 'name_mm' => 'ပုသိမ်ကြီး', 'type' => 'township'],
                            ['name' => 'Pyigyidagun', 'name_mm' => 'ပြည်ကြီးတံခွန်', 'type' => 'township'],
                        ]
                    ],
                    [
                        'name' => 'Pyin Oo Lwin',
                        'name_mm' => 'ပြင်ဦးလွင်',
                        'type' => 'city',
                        'children' => []
                    ],
                    [
                        'name' => 'Meiktila',
                        'name_mm' => 'မိတ္ထီလာ',
                        'type' => 'city',
                        'children' => []
                    ]
                ]
            ],
            // Nay Pyi Taw
            [
                'name' => 'Nay Pyi Taw',
                'name_mm' => 'နေပြည်တော်',
                'type' => 'region',
                'children' => [
                    [
                        'name' => 'Pyinmana',
                        'name_mm' => 'ပျဉ်းမနား',
                        'type' => 'city',
                        'children' => []
                    ],
                    [
                        'name' => 'Lewe',
                        'name_mm' => 'လယ်ဝေး',
                        'type' => 'town',
                        'children' => []
                    ]
                ]
            ],
            // Bago Region
            [
                'name' => 'Bago Region',
                'name_mm' => 'ပဲခူးတိုင်းဒေသကြီး',
                'type' => 'region',
                'children' => [
                    [
                        'name' => 'Bago',
                        'name_mm' => 'ပဲခူး',
                        'type' => 'city',
                        'children' => []
                    ],
                    [
                        'name' => 'Pyay',
                        'name_mm' => 'ပြည်',
                        'type' => 'city',
                        'children' => []
                    ]
                ]
            ],
            // Ayeyarwady Region
            [
                'name' => 'Ayeyarwady Region',
                'name_mm' => 'ဧရာဝတီတိုင်းဒေသကြီး',
                'type' => 'region',
                'children' => [
                    [
                        'name' => 'Pathein',
                        'name_mm' => 'ပုသိမ်',
                        'type' => 'city',
                        'children' => []
                    ],
                    [
                        'name' => 'Hinthada',
                        'name_mm' => 'ဟင်္သာတ',
                        'type' => 'city',
                        'children' => []
                    ]
                ]
            ],
            // Mon State
            [
                'name' => 'Mon State',
                'name_mm' => 'မွန်ပြည်နယ်',
                'type' => 'region',
                'children' => [
                    [
                        'name' => 'Mawlamyine',
                        'name_mm' => 'မော်လမြိုင်',
                        'type' => 'city',
                        'children' => []
                    ],
                    [
                        'name' => 'Kyaikto',
                        'name_mm' => 'ကျိုက်ထို',
                        'type' => 'town',
                        'children' => []
                    ]
                ]
            ],
            // Shan State
            [
                'name' => 'Shan State',
                'name_mm' => 'ရှမ်းပြည်နယ်',
                'type' => 'region',
                'children' => [
                    [
                        'name' => 'Taunggyi',
                        'name_mm' => 'တောင်ကြီး',
                        'type' => 'city',
                        'children' => []
                    ],
                    [
                        'name' => 'Kalaw',
                        'name_mm' => 'ကလော',
                        'type' => 'town',
                        'children' => []
                    ],
                    [
                        'name' => 'Nyaung Shwe',
                        'name_mm' => 'ညောင်ရွှေ',
                        'type' => 'town',
                        'children' => []
                    ]
                ]
            ],
            // Kachin State
            [
                'name' => 'Kachin State',
                'name_mm' => 'ကချင်ပြည်နယ်',
                'type' => 'region',
                'children' => [
                    [
                        'name' => 'Myitkyina',
                        'name_mm' => 'မြစ်ကြီးနား',
                        'type' => 'city',
                        'children' => []
                    ],
                    [
                        'name' => 'Bhamo',
                        'name_mm' => 'ဗန်းမော်',
                        'type' => 'city',
                        'children' => []
                    ]
                ]
            ],
            // Rakhine State
            [
                'name' => 'Rakhine State',
                'name_mm' => 'ရခိုင်ပြည်နယ်',
                'type' => 'region',
                'children' => [
                    [
                        'name' => 'Sittwe',
                        'name_mm' => 'စစ်တွေ',
                        'type' => 'city',
                        'children' => []
                    ],
                    [
                        'name' => 'Kyaukpyu',
                        'name_mm' => 'ကျောက်ဖြူ',
                        'type' => 'town',
                        'children' => []
                    ]
                ]
            ],
            // Sagaing Region
            [
                'name' => 'Sagaing Region',
                'name_mm' => 'စစ်ကိုင်းတိုင်းဒေသကြီး',
                'type' => 'region',
                'children' => [
                    [
                        'name' => 'Sagaing',
                        'name_mm' => 'စစ်ကိုင်း',
                        'type' => 'city',
                        'children' => []
                    ],
                    [
                        'name' => 'Monywa',
                        'name_mm' => 'မုံရွာ',
                        'type' => 'city',
                        'children' => []
                    ],
                    [
                        'name' => 'Shwebo',
                        'name_mm' => 'ရွှေဘို',
                        'type' => 'city',
                        'children' => []
                    ]
                ]
            ],
            // Tanintharyi Region
            [
                'name' => 'Tanintharyi Region',
                'name_mm' => 'တနင်္သာရီတိုင်းဒေသကြီး',
                'type' => 'region',
                'children' => [
                    [
                        'name' => 'Dawei',
                        'name_mm' => 'ထားဝယ်',
                        'type' => 'city',
                        'children' => []
                    ],
                    [
                        'name' => 'Myeik',
                        'name_mm' => 'မြိတ်',
                        'type' => 'city',
                        'children' => []
                    ],
                    [
                        'name' => 'Kawthaung',
                        'name_mm' => 'ကော့သောင်း',
                        'type' => 'town',
                        'children' => []
                    ]
                ]
            ],
            // Magway Region
            [
                'name' => 'Magway Region',
                'name_mm' => 'မကွေးတိုင်းဒေသကြီး',
                'type' => 'region',
                'children' => [
                    [
                        'name' => 'Magway',
                        'name_mm' => 'မကွေး',
                        'type' => 'city',
                        'children' => []
                    ],
                    [
                        'name' => 'Pakokku',
                        'name_mm' => 'ပခုက္ကူ',
                        'type' => 'city',
                        'children' => []
                    ]
                ]
            ]
        ];

        foreach ($locations as $regionData) {
            $this->createLocation($regionData);
        }
    }

    private function createLocation($data, $parent = null)
    {
        $children = $data['children'] ?? [];
        unset($data['children']);
        
        if ($parent) {
            $data['parent_id'] = $parent->id;
        }
        
        $data['is_active'] = true;
        $data['sort_order'] = 0;
        
        $location = Location::create($data);
        
        foreach ($children as $childData) {
            $this->createLocation($childData, $location);
        }
    }
}
