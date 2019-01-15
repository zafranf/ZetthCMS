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
        $dash->route_name = 'dashboard';
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
        $set->order = $mainOrder++;
        $set->status = 1;
        $set->index = 1;
        $set->save();

        /* menu aplikasi */
        $setApl = new Menu;
        $setApl->name = 'Aplikasi';
        $setApl->description = 'Menu pengaturan aplikasi';
        $setApl->route_name = 'application';
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
        $setMenu->route_name = 'menus';
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
        $setRole->route_name = 'roles';
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
        $setUser->route_name = 'users';
        $setUser->order = $setOrder++;
        $setUser->status = 1;
        $setUser->parent_id = $set->id;
        $setUser->index = 1;
        $setUser->create = 1;
        $setUser->read = 1;
        $setUser->update = 1;
        $setUser->delete = 1;
        $setUser->save();

        $kontenOrder = 1;
        /* menu konten (grup) */
        $konten = new Menu;
        $konten->name = 'Konten';
        $konten->description = 'Grup menu konten';
        $konten->order = $mainOrder++;
        $konten->status = 1;
        $konten->index = 1;
        $konten->save();

        /* menu spanduk */
        $kontenBanner = new Menu;
        $kontenBanner->name = 'Spanduk';
        $kontenBanner->description = 'Menu pengaturan spanduk';
        $kontenBanner->route_name = 'banners';
        $kontenBanner->order = $kontenOrder++;
        $kontenBanner->status = 1;
        $kontenBanner->parent_id = $konten->id;
        $kontenBanner->index = 1;
        $kontenBanner->create = 1;
        $kontenBanner->read = 0;
        $kontenBanner->update = 1;
        $kontenBanner->delete = 1;
        $kontenBanner->save();

        /* menu artikel */
        $kontenPost = new Menu;
        $kontenPost->name = 'Artikel';
        $kontenPost->description = 'Menu pengaturan artikel';
        $kontenPost->route_name = 'posts';
        $kontenPost->order = $kontenOrder++;
        $kontenPost->status = 1;
        $kontenPost->parent_id = $konten->id;
        $kontenPost->index = 1;
        $kontenPost->create = 1;
        $kontenPost->read = 1;
        $kontenPost->update = 1;
        $kontenPost->delete = 1;
        $kontenPost->save();

        /* menu halaman */
        $kontenPage = new Menu;
        $kontenPage->name = 'Halaman';
        $kontenPage->description = 'Menu pengaturan halaman';
        $kontenPage->route_name = 'pages';
        $kontenPage->order = $kontenOrder++;
        $kontenPage->status = 1;
        $kontenPage->parent_id = $konten->id;
        $kontenPage->index = 1;
        $kontenPage->create = 1;
        $kontenPage->read = 1;
        $kontenPage->update = 1;
        $kontenPage->delete = 1;
        $kontenPage->save();

        /* menu kategori */
        $kontenCat = new Menu;
        $kontenCat->name = 'Kategori';
        $kontenCat->description = 'Menu pengaturan kategori';
        $kontenCat->route_name = 'categories';
        $kontenCat->order = $kontenOrder++;
        $kontenCat->status = 1;
        $kontenCat->parent_id = $konten->id;
        $kontenCat->index = 1;
        $kontenCat->create = 1;
        $kontenCat->read = 0;
        $kontenCat->update = 1;
        $kontenCat->delete = 1;
        $kontenCat->save();

        /* menu label */
        $kontenTag = new Menu;
        $kontenTag->name = 'Label';
        $kontenTag->description = 'Menu pengaturan label';
        $kontenTag->route_name = 'tags';
        $kontenTag->order = $kontenOrder++;
        $kontenTag->status = 1;
        $kontenTag->parent_id = $konten->id;
        $kontenTag->index = 1;
        $kontenTag->create = 1;
        $kontenTag->read = 0;
        $kontenTag->update = 1;
        $kontenTag->delete = 1;
        $kontenTag->save();

        $galOrder = 1;
        /* menu galeri (grup) */
        $gallery = new Menu;
        $gallery->name = 'Galeri';
        $gallery->description = 'Grup menu galeri';
        $gallery->order = $kontenOrder++;
        $gallery->status = 1;
        $gallery->parent_id = $konten->id;
        $gallery->index = 1;
        $gallery->save();

        /* menu foto */
        $galPhoto = new Menu;
        $galPhoto->name = 'Foto';
        $galPhoto->description = 'Menu pengaturan foto';
        $galPhoto->route_name = 'photos';
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
        $galVideo->route_name = 'videos';
        $galVideo->order = $galOrder++;
        $galVideo->status = 1;
        $galVideo->parent_id = $gallery->id;
        $galVideo->index = 1;
        $galVideo->create = 1;
        $galVideo->read = 0;
        $galVideo->update = 1;
        $galVideo->delete = 1;
        $galVideo->save();

        $prodOrder = 1;
        /* menu produk (grup) */
        $product = new Menu;
        $product->name = 'Produk';
        $product->description = 'Grup menu produk';
        $product->order = $kontenOrder++;
        $product->status = 1;
        $product->parent_id = $konten->id;
        $product->index = 1;
        $product->save();

        /* menu semua produk */
        $prodAll = new Menu;
        $prodAll->name = 'Semua Produk';
        $prodAll->description = 'Menu pengaturan semua produk';
        $prodAll->route_name = 'products';
        $prodAll->order = $prodOrder++;
        $prodAll->status = 1;
        $prodAll->parent_id = $product->id;
        $prodAll->index = 1;
        $prodAll->create = 1;
        $prodAll->read = 1;
        $prodAll->update = 1;
        $prodAll->delete = 1;
        $prodAll->save();

        /* menu produk kategori */
        $prodCat = new Menu;
        $prodCat->name = 'Kategori';
        $prodCat->description = 'Menu pengaturan produk kategori';
        $prodCat->route_name = 'products.categories';
        $prodCat->order = $prodOrder++;
        $prodCat->status = 1;
        $prodCat->parent_id = $product->id;
        $prodCat->index = 1;
        $prodCat->create = 1;
        $prodCat->read = 0;
        $prodCat->update = 1;
        $prodCat->delete = 1;
        $prodCat->save();

        /* menu produk label */
        $prodTag = new Menu;
        $prodTag->name = 'Label';
        $prodTag->description = 'Menu pengaturan produk label';
        $prodTag->route_name = 'products.tags';
        $prodTag->order = $prodOrder++;
        $prodTag->status = 1;
        $prodTag->parent_id = $product->id;
        $prodTag->index = 1;
        $prodTag->create = 1;
        $prodTag->read = 0;
        $prodTag->update = 1;
        $prodTag->delete = 1;
        $prodTag->save();

        $repOrder = 1;
        /* menu laporan (grup) */
        $report = new Menu;
        $report->name = 'Laporan';
        $report->description = 'Grup menu laporan';
        $report->order = $mainOrder++;
        $report->status = 1;
        $report->index = 1;
        $report->save();

        /* menu kontak masuk */
        $repInbox = new Menu;
        $repInbox->name = 'Kontak Masuk';
        $repInbox->description = 'Menu pengaturan kontak masuk';
        $repInbox->route_name = 'inbox';
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
        $repComment->route_name = 'comments';
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
        $repInterm->route_name = 'interms';
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
        $repSubscriber->route_name = 'subscribers';
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
        $log->order = $mainOrder++;
        $log->status = 1;
        $log->index = 1;
        $log->save();

        /* menu catatan aktifitas */
        $logActivity = new Menu;
        $logActivity->name = 'Aktifitas';
        $logActivity->description = 'Menu catatan aktifitas';
        $logActivity->route_name = 'activities';
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
        $logError->route_name = 'errors';
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
