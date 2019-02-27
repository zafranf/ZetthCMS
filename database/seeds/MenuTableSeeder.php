<?php

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mainOrder = 1;
        /* menu dashboard */
        $dash = new Menu;
        $dash->name = 'Beranda';
        $dash->description = 'Halaman utama aplikasi';
        $dash->route_name = 'dashboard.index';
        $dash->icon = 'pg-home';
        $dash->target = '_self';
        $dash->order = $mainOrder++;
        $dash->status = 1;
        $dash->index = 1;
        $dash->save();

        $setOrder = 1;
        /* menu pengaturan (grup) */
        $set = new Menu;
        $set->name = 'Pengaturan';
        $set->description = 'Grup menu pegaturan';
        $set->icon = 'pg-settings';
        $set->order = $mainOrder++;
        $set->status = 1;
        $set->index = 1;
        $set->save();

        /* menu aplikasi */
        $setApl = new Menu;
        $setApl->name = 'Aplikasi';
        $setApl->description = 'Menu pengaturan aplikasi';
        $setApl->route_name = 'application.index';
        $setApl->icon = 'pg-desktop';
        $setApl->order = $setOrder++;
        $setApl->status = 1;
        $setApl->parent_id = $set->id;
        $setApl->index = 1;
        $setApl->create = 0;
        $setApl->read = 0;
        $setApl->update = 1;
        $setApl->delete = 0;
        $setApl->save();

        /* menu menu */
        $setMenu = new Menu;
        $setMenu->name = 'Menu';
        $setMenu->description = 'Menu pengaturan menu';
        $setMenu->route_name = 'menus.index';
        $setMenu->icon = 'pg-menu';
        $setMenu->order = $setOrder++;
        $setMenu->status = 1;
        $setMenu->parent_id = $set->id;
        $setMenu->index = 1;
        $setMenu->create = 1;
        $setMenu->read = 0;
        $setMenu->update = 1;
        $setMenu->delete = 1;
        $setMenu->save();

        /* menu peran */
        $setRole = new Menu;
        $setRole->name = 'Peran dan Akses';
        $setRole->description = 'Menu pengaturan peran dan akses';
        $setRole->route_name = 'roles.index';
        $setRole->icon = 'fa fa-key';
        $setRole->order = $setOrder++;
        $setRole->status = 1;
        $setRole->parent_id = $set->id;
        $setRole->index = 1;
        $setRole->create = 1;
        $setRole->read = 0;
        $setRole->update = 1;
        $setRole->delete = 1;
        $setRole->save();

        /* menu pengguna */
        $setUser = new Menu;
        $setUser->name = 'Pengguna';
        $setUser->description = 'Menu pengaturan pengguna';
        $setUser->route_name = 'users.index';
        $setUser->icon = 'fa fa-user';
        $setUser->order = $setOrder++;
        $setUser->status = 1;
        $setUser->parent_id = $set->id;
        $setUser->index = 1;
        $setUser->create = 1;
        $setUser->read = 1;
        $setUser->update = 1;
        $setUser->delete = 1;
        $setUser->save();

        $contentOrder = 1;
        /* menu konten (grup) */
        $content = new Menu;
        $content->name = 'Konten';
        $content->description = 'Grup menu konten';
        $content->icon = 'fa fa-edit';
        $content->order = $mainOrder++;
        $content->status = 1;
        $content->index = 1;
        $content->save();

        /* menu spanduk */
        $contentBanner = new Menu;
        $contentBanner->name = 'Spanduk';
        $contentBanner->description = 'Menu pengaturan spanduk';
        $contentBanner->route_name = 'banners.index';
        $contentBanner->icon = 'pg-tablet';
        $contentBanner->order = $contentOrder++;
        $contentBanner->status = 1;
        $contentBanner->parent_id = $content->id;
        $contentBanner->index = 1;
        $contentBanner->create = 1;
        $contentBanner->read = 0;
        $contentBanner->update = 1;
        $contentBanner->delete = 1;
        $contentBanner->save();

        /* menu halaman */
        $contentPage = new Menu;
        $contentPage->name = 'Halaman';
        $contentPage->description = 'Menu pengaturan halaman';
        $contentPage->route_name = 'pages.index';
        $contentPage->icon = 'fa fa-file-text';
        $contentPage->order = $contentOrder++;
        $contentPage->status = 1;
        $contentPage->parent_id = $content->id;
        $contentPage->index = 1;
        $contentPage->create = 1;
        $contentPage->read = 1;
        $contentPage->update = 1;
        $contentPage->delete = 1;
        $contentPage->save();

        $postOrder = 1;
        /* menu artikel (grup) */
        $post = new Menu;
        $post->name = 'Artikel';
        $post->description = 'Menu pengaturan artikel';
        // $post->route_name = 'posts.index';
        $post->icon = 'fa fa-newspaper-o';
        $post->order = $contentOrder++;
        $post->status = 1;
        $post->parent_id = $content->id;
        $post->index = 1;
        // $post->create = 1;
        // $post->read = 1;
        // $post->update = 1;
        // $post->delete = 1;
        $post->save();

        /* menu semua artikel */
        $postAll = new Menu;
        $postAll->name = 'Semua Artikel';
        $postAll->description = 'Menu pengaturan semua artikel';
        $postAll->route_name = 'posts.index';
        $postAll->icon = 'fa fa-newspaper-o';
        $postAll->order = $postOrder++;
        $postAll->status = 1;
        $postAll->parent_id = $post->id;
        $postAll->index = 1;
        $postAll->create = 1;
        $postAll->read = 1;
        $postAll->update = 1;
        $postAll->delete = 1;
        $postAll->save();

        /* menu kategori */
        $postCat = new Menu;
        $postCat->name = 'Kategori';
        $postCat->description = 'Menu pengaturan kategori';
        $postCat->route_name = 'categories.index';
        $postCat->icon = 'pg-unordered_list';
        $postCat->order = $postOrder++;
        $postCat->status = 1;
        $postCat->parent_id = $post->id;
        $postCat->index = 1;
        $postCat->create = 1;
        $postCat->read = 0;
        $postCat->update = 1;
        $postCat->delete = 1;
        $postCat->save();

        /* menu label */
        $postTag = new Menu;
        $postTag->name = 'Label';
        $postTag->description = 'Menu pengaturan label';
        $postTag->route_name = 'tags.index';
        $postTag->icon = 'fa fa-list';
        $postTag->order = $postOrder++;
        $postTag->status = 1;
        $postTag->parent_id = $post->id;
        $postTag->index = 1;
        $postTag->create = 1;
        $postTag->read = 0;
        $postTag->update = 1;
        $postTag->delete = 1;
        $postTag->save();

        $galOrder = 1;
        /* menu galeri (grup) */
        $gallery = new Menu;
        $gallery->name = 'Galeri';
        $gallery->description = 'Grup menu galeri';
        $gallery->icon = 'fa fa-camera';
        $gallery->order = $contentOrder++;
        $gallery->status = 1;
        $gallery->parent_id = $content->id;
        $gallery->index = 1;
        $gallery->save();

        /* menu foto */
        $galPhoto = new Menu;
        $galPhoto->name = 'Foto';
        $galPhoto->description = 'Menu pengaturan foto';
        $galPhoto->route_name = 'photos.index';
        $galPhoto->icon = 'fa fa-photo';
        $galPhoto->order = $galOrder++;
        $galPhoto->status = 1;
        $galPhoto->parent_id = $gallery->id;
        $galPhoto->index = 1;
        $galPhoto->create = 1;
        $galPhoto->read = 0;
        $galPhoto->update = 1;
        $galPhoto->delete = 1;
        $galPhoto->save();

        /* menu video */
        $galVideo = new Menu;
        $galVideo->name = 'Video';
        $galVideo->description = 'Menu pengaturan video';
        $galVideo->route_name = 'videos.index';
        $galVideo->icon = 'pg-video';
        $galVideo->order = $galOrder++;
        $galVideo->status = 1;
        $galVideo->parent_id = $gallery->id;
        $galVideo->index = 1;
        $galVideo->create = 1;
        $galVideo->read = 0;
        $galVideo->update = 1;
        $galVideo->delete = 1;
        $galVideo->save();

        // $prodOrder = 1;
        /* menu produk (grup) */
        /* $product = new Menu;
        $product->name = 'Produk';
        $product->description = 'Grup menu produk';
        $product->icon = 'fa fa-shopping-cart';
        $product->order = $contentOrder++;
        $product->status = 1;
        $product->parent_id = $content->id;
        $product->index = 1;
        $product->save(); */

        /* menu semua produk */
        /* $prodAll = new Menu;
        $prodAll->name = 'Semua Produk';
        $prodAll->description = 'Menu pengaturan semua produk';
        $prodAll->route_name = 'products.index';
        $prodAll->icon = 'pg-shopping_cart';
        $prodAll->order = $prodOrder++;
        $prodAll->status = 1;
        $prodAll->parent_id = $product->id;
        $prodAll->index = 1;
        $prodAll->create = 1;
        $prodAll->read = 1;
        $prodAll->update = 1;
        $prodAll->delete = 1;
        $prodAll->save(); */

        /* menu produk kategori */
        /* $prodCat = new Menu;
        $prodCat->name = 'Kategori';
        $prodCat->description = 'Menu pengaturan produk kategori';
        $prodCat->route_name = 'products.categories.index';
        $prodCat->icon = 'pg-unordered_list';
        $prodCat->order = $prodOrder++;
        $prodCat->status = 1;
        $prodCat->parent_id = $product->id;
        $prodCat->index = 1;
        $prodCat->create = 1;
        $prodCat->read = 0;
        $prodCat->update = 1;
        $prodCat->delete = 1;
        $prodCat->save(); */

        /* menu produk label */
        /* $prodTag = new Menu;
        $prodTag->name = 'Label';
        $prodTag->description = 'Menu pengaturan produk label';
        $prodTag->route_name = 'products.tags.index';
        $prodTag->icon = 'fa fa-list';
        $prodTag->order = $prodOrder++;
        $prodTag->status = 1;
        $prodTag->parent_id = $product->id;
        $prodTag->index = 1;
        $prodTag->create = 1;
        $prodTag->read = 0;
        $prodTag->update = 1;
        $prodTag->delete = 1;
        $prodTag->save(); */

        $repOrder = 1;
        /* menu laporan (grup) */
        $report = new Menu;
        $report->name = 'Laporan';
        $report->description = 'Grup menu laporan';
        $report->icon = 'pg-charts';
        $report->order = $mainOrder++;
        $report->status = 1;
        $report->index = 1;
        $report->save();

        /* menu kontak masuk */
        $repInbox = new Menu;
        $repInbox->name = 'Kontak Masuk';
        $repInbox->description = 'Menu pengaturan kontak masuk';
        $repInbox->route_name = 'inbox.index';
        $repInbox->icon = 'pg-mail';
        $repInbox->order = $repOrder++;
        $repInbox->status = 1;
        $repInbox->parent_id = $report->id;
        $repInbox->index = 1;
        $repInbox->create = 0;
        $repInbox->read = 1;
        $repInbox->update = 0;
        $repInbox->delete = 1;
        $repInbox->save();

        /* menu komentar */
        $repComment = new Menu;
        $repComment->name = 'Komentar';
        $repComment->description = 'Menu pengaturan komentar';
        $repComment->route_name = 'comments.index';
        $repComment->icon = 'fa fa-comments';
        $repComment->order = $repOrder++;
        $repComment->status = 1;
        $repComment->parent_id = $report->id;
        $repComment->index = 1;
        $repComment->create = 1;
        $repComment->read = 1;
        $repComment->update = 1;
        $repComment->delete = 1;
        $repComment->save();

        /* menu kata pencarian */
        $repInterm = new Menu;
        $repInterm->name = 'Kata Pencarian';
        $repInterm->description = 'Menu pengaturan kata pencarian';
        $repInterm->route_name = 'interms.index';
        $repInterm->icon = 'pg-search';
        $repInterm->order = $repOrder++;
        $repInterm->status = 1;
        $repInterm->parent_id = $report->id;
        $repInterm->index = 1;
        $repInterm->create = 0;
        $repInterm->read = 0;
        $repInterm->update = 0;
        $repInterm->delete = 0;
        $repInterm->save();

        /* menu pelanggan info */
        $repSubscriber = new Menu;
        $repSubscriber->name = 'Pelanggan Info';
        $repSubscriber->description = 'Menu laporan pelanggan info';
        $repSubscriber->route_name = 'subscribers.index';
        $repSubscriber->icon = 'fa fa-users';
        $repSubscriber->order = $repOrder++;
        $repSubscriber->status = 1;
        $repSubscriber->parent_id = $report->id;
        $repSubscriber->index = 1;
        $repSubscriber->create = 0;
        $repSubscriber->read = 0;
        $repSubscriber->update = 1;
        $repSubscriber->delete = 1;
        $repSubscriber->save();

        $logOrder = 1;
        /* menu catatan (grup) */
        $log = new Menu;
        $log->name = 'Catatan';
        $log->description = 'Grup menu catatan';
        $log->icon = 'pg-note';
        $log->order = $mainOrder++;
        $log->status = 1;
        $log->index = 1;
        $log->save();

        /* menu catatan aktifitas */
        $logActivity = new Menu;
        $logActivity->name = 'Aktifitas';
        $logActivity->description = 'Menu catatan aktifitas';
        $logActivity->route_name = 'activities.index';
        $logActivity->icon = 'fa fa-list';
        $logActivity->order = $logOrder++;
        $logActivity->status = 1;
        $logActivity->parent_id = $log->id;
        $logActivity->index = 1;
        $logActivity->create = 0;
        $logActivity->read = 1;
        $logActivity->update = 0;
        $logActivity->delete = 0;
        $logActivity->save();

        /* menu catatan galat */
        $logError = new Menu;
        $logError->name = 'Galat';
        $logError->description = 'Menu catatan galat';
        $logError->route_name = 'errors.index';
        $logError->icon = 'fa fa-list-ul';
        $logError->order = $logOrder++;
        $logError->status = 1;
        $logError->parent_id = $log->id;
        $logError->index = 1;
        $logError->create = 0;
        $logError->read = 1;
        $logError->update = 0;
        $logError->delete = 0;
        $logError->save();
    }
}
