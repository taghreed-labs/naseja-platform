<?php



namespace App\Http\Controllers;



use App\Models\User;

use App\Models\Category;

use App\Models\PortfolioItem;

use App\Models\Service;

use App\Models\Favorite;

use Illuminate\Http\Request;

use Illuminate\View\View;



class ExploreController extends Controller

{

    /**

     * صفحة الاستكشاف.

     */

    public function index(Request $request): View

    {

        /*

        |--------------------------------------------------------------------------

        | البحث والتصنيف

        |--------------------------------------------------------------------------

        */



        $search = trim($request->input('search', ''));



        $category = trim($request->input('category', ''));





        /*

        |--------------------------------------------------------------------------

        | التصنيفات

        |--------------------------------------------------------------------------

        */



        $categories = Category::query()

            ->where('status', 'active')

            ->whereNull('parent_id')

            ->orderBy('sort_order')

            ->get();





        /*

        |--------------------------------------------------------------------------

        | التصنيف المختار

        |--------------------------------------------------------------------------

        */



        $selectedCategory = null;



        if ($category !== '') {



            $selectedCategory = $categories->firstWhere(

                'slug',

                $category

            );

        }





        /*

        |--------------------------------------------------------------------------

        | رقم التصنيف

        |--------------------------------------------------------------------------

        */



        $categoryId = $selectedCategory?->id;





        /*

        |--------------------------------------------------------------------------

        | المستخدمون - أصحاب المهارات المعتمدون فقط

        |--------------------------------------------------------------------------

        |

        | لا نعرض:

        |

        | - الحسابات غير النشطة

        | - الحسابات pending

        | - الحسابات rejected

        | - الحسابات التي لا تمتلك مهارة

        |

        */



        $usersQuery = User::query()

            ->with([

                'profile',

                'userSkills.skill.category',

            ])

            ->where('status', 'active')

            ->where('approval_status', 'approved')

            ->whereHas('userSkills')
            ->whereHas('roles', fn ($query) => $query->where('slug', 'provider'));





        /*

        |--------------------------------------------------------------------------

        | استبعاد المستخدم الحالي

        |--------------------------------------------------------------------------

        */



        if (auth()->check()) {



            $usersQuery->where(

                'id',

                '!=',

                auth()->id()

            );

        }





        /*

        |--------------------------------------------------------------------------

        | فلترة المستخدمين حسب المجال

        |--------------------------------------------------------------------------

        */



        if ($categoryId) {



            $usersQuery->whereHas(

                'userSkills.skill',

                function ($skillQuery) use ($categoryId) {



                    $skillQuery->where(

                        'category_id',

                        $categoryId

                    );

                }

            );

        }





        /*

        |--------------------------------------------------------------------------

        | البحث في المستخدمين

        |--------------------------------------------------------------------------

        */



        if ($search !== '') {



            $usersQuery->where(function ($query) use ($search) {



                /*

                | البحث باسم المستخدم

                */



                $query->where(

                    'name',

                    'like',

                    "%{$search}%"

                )



                /*

                | البحث في الملف الشخصي

                */



                ->orWhereHas(

                    'profile',

                    function ($profileQuery) use ($search) {



                        $profileQuery

                            ->where(

                                'bio_ar',

                                'like',

                                "%{$search}%"

                            )



                            ->orWhere(

                                'bio_en',

                                'like',

                                "%{$search}%"

                            )



                            ->orWhere(

                                'location',

                                'like',

                                "%{$search}%"

                            );

                    }

                )



                /*

                | البحث في المهارات

                */



                ->orWhereHas(

                    'userSkills.skill',

                    function ($skillQuery) use ($search) {



                        $skillQuery

                            ->where(

                                'name_ar',

                                'like',

                                "%{$search}%"

                            )



                            ->orWhere(

                                'name_en',

                                'like',

                                "%{$search}%"

                            );

                    }

                );



            });

        }





        /*

        |--------------------------------------------------------------------------

        | جلب المستخدمين

        |--------------------------------------------------------------------------

        */



        $users = $usersQuery

            ->orderByRaw("

                CASE

                    WHEN id = 3 THEN 1

                    WHEN id = 4 THEN 2

                    WHEN id = 6 THEN 3

                    ELSE 4

                END

            ")

            ->latest()

            ->get();





        /*

        |--------------------------------------------------------------------------

        | المفضلة

        |--------------------------------------------------------------------------

        */



        $favoriteUserIds = collect();



        if (auth()->check()) {



            $favoriteUserIds = Favorite::where(

                'user_id',

                auth()->id()

            )

            ->pluck('favorite_user_id');

        }





        /*

        |--------------------------------------------------------------------------

        | أحدث الأعمال

        |--------------------------------------------------------------------------

        |

        | العمل يجب أن يكون نشطًا،

        | وصاحبه يجب أن يكون نشطًا ومعتمدًا.

        |

        */



        $portfolioItemsQuery = PortfolioItem::query()

            ->with([

                'user.profile',

                'images',

            ])

            ->where('status', 'active')



            ->whereHas(

                'user',

                function ($userQuery) {



                    $userQuery

                        ->where('status', 'active')

                        ->where(

                            'approval_status',

                            'approved'

                        )
                        ->whereHas('roles', fn ($query) => $query->where('slug', 'provider'));

                }

            );





        /*

        |--------------------------------------------------------------------------

        | فلترة الأعمال حسب المجال

        |--------------------------------------------------------------------------

        */



        if ($categoryId) {



            $portfolioItemsQuery->whereHas(

                'user.userSkills.skill',

                function ($skillQuery) use ($categoryId) {



                    $skillQuery->where(

                        'category_id',

                        $categoryId

                    );

                }

            );

        }





        /*

        |--------------------------------------------------------------------------

        | البحث في الأعمال

        |--------------------------------------------------------------------------

        */



        if ($search !== '') {



            $portfolioItemsQuery->where(function ($query) use ($search) {



                $query

                    ->where(

                        'title_ar',

                        'like',

                        "%{$search}%"

                    )



                    ->orWhere(

                        'title_en',

                        'like',

                        "%{$search}%"

                    )



                    ->orWhere(

                        'description_ar',

                        'like',

                        "%{$search}%"

                    )



                    ->orWhere(

                        'description_en',

                        'like',

                        "%{$search}%"

                    );



            });

        }





        /*

        |--------------------------------------------------------------------------

        | جلب الأعمال

        |--------------------------------------------------------------------------

        */



        $portfolioItems = $portfolioItemsQuery

            ->latest()

            ->take(6)

            ->get();





        /*

        |--------------------------------------------------------------------------

        | الخدمات

        |--------------------------------------------------------------------------

        |

        | الخدمة يجب أن تكون نشطة،

        | وصاحبها يجب أن يكون نشطًا ومعتمدًا.

        |

        */



        $servicesQuery = Service::query()

            ->with([

                'user.profile',

                'category',

            ])

            ->where('status', 'active')



            ->whereHas(

                'user',

                function ($userQuery) {



                    $userQuery

                        ->where('status', 'active')

                        ->where(

                            'approval_status',

                            'approved'

                        )
                        ->whereHas('roles', fn ($query) => $query->where('slug', 'provider'));

                }

            );





        /*

        |--------------------------------------------------------------------------

        | فلترة الخدمات حسب المجال

        |--------------------------------------------------------------------------

        */



        if ($categoryId) {



            $servicesQuery->where(

                'category_id',

                $categoryId

            );

        }





        /*

        |--------------------------------------------------------------------------

        | البحث في الخدمات

        |--------------------------------------------------------------------------

        */



        if ($search !== '') {



            $servicesQuery->where(function ($query) use ($search) {



                $query

                    ->where(

                        'title_ar',

                        'like',

                        "%{$search}%"

                    )



                    ->orWhere(

                        'title_en',

                        'like',

                        "%{$search}%"

                    )



                    ->orWhere(

                        'description_ar',

                        'like',

                        "%{$search}%"

                    )



                    ->orWhere(

                        'description_en',

                        'like',

                        "%{$search}%"

                    );



            });

        }





        /*

        |--------------------------------------------------------------------------

        | جلب الخدمات

        |--------------------------------------------------------------------------

        */



        $services = $servicesQuery

            ->latest()

            ->take(6)

            ->get();





        /*

        |--------------------------------------------------------------------------

        | إرسال البيانات إلى صفحة الاستكشاف

        |--------------------------------------------------------------------------

        */



        return view(

            'layouts.frontend.user.explore',

            compact(

                'users',

                'portfolioItems',

                'services',

                'categories',

                'search',

                'category',

                'categoryId',

                'selectedCategory',

                'favoriteUserIds'

            )

        );

    }

}
