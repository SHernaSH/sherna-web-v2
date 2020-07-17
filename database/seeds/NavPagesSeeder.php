<?php

use Illuminate\Database\Seeder;

class NavPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Navigation\Page::updateOrInsert([
            'id' => 1,
            'url'   => 'about',
            'name'   => 'O Sherne',
            'language_id' => 1,
            'order' => 1,
            'public' => true,
            'dropdown' => true
        ]);
        \App\Models\Navigation\Page::updateOrInsert([
            'id' => 1,
            'url'   => 'about',
            'name'   => 'About Sherna',
            'language_id' => 2,
            'order' => 1,
            'public' => true,
            'dropdown' => true
        ]);

        \App\Models\Navigation\Page::updateOrInsert([
            'id' => 2,
            'url'   => 'home',
            'name'   => 'Domov',
            'language_id' => 1,
            'order' => 0,
            'public' => true,
            'dropdown' => false,
            'special_code' => 'home'
        ]);
        \App\Models\Navigation\Page::updateOrInsert([
            'id' => 2,
            'url'   => 'home',
            'name'   => 'Home',
            'language_id' => 2,
            'order' => 0,
            'public' => true,
            'dropdown' => false,
            'special_code' => 'home'
        ]);

        \App\Models\Navigation\Page::updateOrInsert([
            'id' => 3,
            'url'   => 'reservation',
            'name'   => 'Rezervace',
            'language_id' => 1,
            'order' => 2,
            'public' => true,
            'dropdown' => false,
            'special_code' => 'reservation'
        ]);
        \App\Models\Navigation\Page::updateOrInsert([
            'id' => 3,
            'url'   => 'reservation',
            'name'   => 'Reservation',
            'language_id' => 2,
            'order' => 2,
            'public' => true,
            'dropdown' => false,
            'special_code' => 'reservation'
        ]);

        \App\Models\Navigation\Page::updateOrInsert([
            'id' => 4,
            'url'   => 'inventory',
            'name'   => 'Vybaveni',
            'language_id' => 1,
            'order' => 3,
            'public' => true,
            'dropdown' => false,
            'special_code' => 'inventory'
        ]);
        \App\Models\Navigation\Page::updateOrInsert([
            'id' => 4,
            'url'   => 'inventory',
            'name'   => 'Inventory',
            'language_id' => 2,
            'order' => 3,
            'public' => true,
            'dropdown' => false,
            'special_code' => 'inventory'
        ]);

        \App\Models\Navigation\Page::updateOrInsert([
            'id' => 5,
            'url'   => 'blog',
            'name'   => 'Blog',
            'language_id' => 1,
            'order' => 4,
            'public' => true,
            'dropdown' => true,
            'special_code' => 'blog'
        ]);
        \App\Models\Navigation\Page::updateOrInsert([
            'id' => 5,
            'url'   => 'blog',
            'name'   => 'Blog',
            'language_id' => 2,
            'order' => 4,
            'public' => true,
            'dropdown' => true,
            'special_code' => 'blog'
        ]);

        \App\Models\Navigation\PageText::updateOrInsert([
            'id' => 1,
            'title'   => 'Rezervace',
            'nav_page_id' => 3,
            'language_id' => 1,
            'content' => 'Reservace exapmle'
        ]);

        \App\Models\Navigation\PageText::updateOrInsert([
            'id' => 2,
            'title'   => 'Reservation',
            'nav_page_id' => 3,
            'language_id' => 2,
            'content' => 'Reservation exapmle'
        ]);

        \App\Models\Navigation\PageText::updateOrInsert([
            'id' => 3,
            'title'   => 'Domov',
            'nav_page_id' => 2,
            'language_id' => 1,
            'content' => 'Vitajte exapmle'
        ]);

        \App\Models\Navigation\PageText::updateOrInsert([
            'id' => 4,
            'title'   => 'Home',
            'nav_page_id' => 2,
            'language_id' => 2,
            'content' => 'Welcome exapmle'
        ]);

        \App\Models\Navigation\PageText::updateOrInsert([
            'id' => 5,
            'title'   => 'Vybavenie',
            'nav_page_id' => 4,
            'language_id' => 1,
            'content' => 'Vitajte exapmle'
        ]);

        \App\Models\Navigation\PageText::updateOrInsert([
            'id' => 6,
            'title'   => 'Inventory',
            'nav_page_id' => 4,
            'language_id' => 2,
            'content' => 'Welcome exapmle'
        ]);

        \App\Models\Navigation\SubPage::updateOrInsert([
            'id' => 1,
            'url'   => 'clenove',
            'name'   => 'Clenove',
            'nav_page_id' => 1,
            'language_id' => 1,
            'order' => 1,
            'public' => true,
        ]);
        \App\Models\Navigation\SubPage::updateOrInsert([
            'id' => 1,
            'url'   => 'clenove',
            'name'   => 'Members',
            'nav_page_id' => 1,
            'language_id' => 2,
            'order' => 2,
            'public' => true,
        ]);
        \App\Models\Navigation\SubPageText::updateOrInsert([
            'id' => 1,
            'title'   => 'Clenove',
            'nav_subpage_id' => 1,
            'language_id' => 1,
            'content' => 'Example exapmle'
        ]);
        \App\Models\Navigation\SubPageText::updateOrInsert([
            'id' => 2,
            'title'   => 'Vyrocne spravy',
            'nav_subpage_id' => 1,
            'language_id' => 2,
            'content' => '2 Example example 2'
        ]);

        \App\Models\Navigation\SubPage::updateOrInsert([
            'id' => 2,
            'url'   => '',
            'name'   => 'Novinky',
            'nav_page_id' => 5,
            'language_id' => 1,
            'order' => 1,
            'public' => true,
        ]);
        \App\Models\Navigation\SubPage::updateOrInsert([
            'id' => 2,
            'url'   => '',
            'name'   => 'News',
            'nav_page_id' => 5,
            'language_id' => 2,
            'order' => 1,
            'public' => true,
        ]);

        \App\Models\Navigation\SubPage::updateOrInsert([
            'id' => 3,
            'url'   => 'categories',
            'name'   => 'Kategorie',
            'nav_page_id' => 5,
            'language_id' => 1,
            'order' => 2,
            'public' => true,
        ]);
        \App\Models\Navigation\SubPage::updateOrInsert([
            'id' => 3,
            'url'   => 'categories',
            'name'   => 'Categories',
            'nav_page_id' => 5,
            'language_id' => 2,
            'order' => 2,
            'public' => true,
        ]);

        \App\Models\Navigation\SubPageText::updateOrInsert([
            'id' => 3,
            'title'   => 'Novinky',
            'nav_subpage_id' => 2,
            'language_id' => 1,
            'content' => 'Nove clanky'
        ]);
        \App\Models\Navigation\SubPageText::updateOrInsert([
            'id' => 4,
            'title'   => 'News',
            'nav_subpage_id' => 2,
            'language_id' => 2,
            'content' => 'New articles'
        ]);

        \App\Models\Navigation\SubPageText::updateOrInsert([
            'id' => 5,
            'title'   => 'Kategorie',
            'nav_subpage_id' => 3,
            'language_id' => 1,
            'content' => 'Vsetky kategorie'
        ]);
        \App\Models\Navigation\SubPageText::updateOrInsert([
            'id' => 6,
            'title'   => 'Vyrocne spravy',
            'nav_subpage_id' => 3,
            'language_id' => 2,
            'content' => 'All categories'
        ]);

    }
}
