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
        /* menu dashboard */
        $dash = new Menu;
        $dash->name = 'Beranda';
        $dash->description = 'Halaman utama aplikasi';
        $dash->route_name = 'dashboard';
        $dash->target = '_self';
        $dash->order = 1;
        $dash->status = 1;
        $dash->index = 1;
        $dash->save();

        /* menu pengaturan (grup) */
        $set = new Menu;
        $set->name = 'Pengaturan';
        $set->description = 'Grup menu pegaturan';
        $set->order = ($dash->order + 1);
        $set->status = 1;
        $set->save();

        /* menu aplikasi */
        $setApl = new Menu;
        $setApl->name = 'Aplikasi';
        $setApl->description = 'Menu pengaturan aplikasi';
        $setApl->route_name = 'application';
        $setApl->order = 1;
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
        $setMenu->order = ($setApl->order + 1);
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
        $setRole->order = ($setMenu->order + 1);
        $setRole->status = 1;
        $setRole->parent_id = $set->id;
        $setRole->index = 1;
        $setRole->create = 1;
        $setRole->read = 0;
        $setRole->update = 1;
        $setRole->delete = 1;
        $setRole->save();

        /* menu pengguna */
        /* $setUser = new Menu;
        $setUser->name = 'Pengguna';
        $setUser->description = 'Menu pengaturan pengguna';
        $setUser->route_name = 'users';
        $setUser->order = ($setRole->order + 1);
        $setUser->status = 1;
        $setUser->parent_id = $set->id;
        $setUser->index = 1;
        $setUser->create = 1;
        $setUser->read = 1;
        $setUser->update = 1;
        $setUser->delete = 1;
        $setUser->save(); */

        /* menu data (grup) */
        $data = new Menu;
        $data->name = 'Data';
        $data->description = 'Grup menu data';
        $data->order = ($set->order + 1);
        $data->status = 1;
        $data->save();

        /* menu pengguna */
        $dataUser = new Menu;
        $dataUser->name = 'Pengguna';
        $dataUser->description = 'Menu pengaturan pengguna';
        $dataUser->route_name = 'users';
        $dataUser->order = 1;
        $dataUser->status = 1;
        $dataUser->parent_id = $data->id;
        $dataUser->index = 1;
        $dataUser->create = 1;
        $dataUser->read = 1;
        $dataUser->update = 1;
        $dataUser->delete = 1;
        $dataUser->save();

        /* menu kategori */
        $dataCat = new Menu;
        $dataCat->name = 'Kategori';
        $dataCat->description = 'Menu pengaturan kategori';
        $dataCat->route_name = 'categories';
        $dataCat->order = ($dataUser->order + 1);
        $dataCat->status = 1;
        $dataCat->parent_id = $data->id;
        $dataCat->index = 1;
        $dataCat->create = 1;
        $dataCat->read = 0;
        $dataCat->update = 1;
        $dataCat->delete = 1;
        $dataCat->save();

        /* menu label */
        $dataTag = new Menu;
        $dataTag->name = 'Label';
        $dataTag->description = 'Menu pengaturan label';
        $dataTag->route_name = 'tags';
        $dataTag->order = ($dataCat->order + 1);
        $dataTag->status = 1;
        $dataTag->parent_id = $data->id;
        $dataTag->index = 1;
        $dataTag->create = 1;
        $dataTag->read = 0;
        $dataTag->update = 1;
        $dataTag->delete = 1;
        $dataTag->save();

        /* menu artikel */
        $dataPost = new Menu;
        $dataPost->name = 'Artikel';
        $dataPost->description = 'Menu pengaturan artikel';
        $dataPost->route_name = 'posts';
        $dataPost->order = ($dataTag->order + 1);
        $dataPost->status = 1;
        $dataPost->parent_id = $data->id;
        $dataPost->index = 1;
        $dataPost->create = 1;
        $dataPost->read = 1;
        $dataPost->update = 1;
        $dataPost->delete = 1;
        $dataPost->save();

        /* menu halaman */
        $dataPage = new Menu;
        $dataPage->name = 'Halaman';
        $dataPage->description = 'Menu pengaturan halaman';
        $dataPage->route_name = 'pages';
        $dataPage->order = ($dataPost->order + 1);
        $dataPage->status = 1;
        $dataPage->parent_id = $data->id;
        $dataPage->index = 1;
        $dataPage->create = 1;
        $dataPage->read = 1;
        $dataPage->update = 1;
        $dataPage->delete = 1;
        $dataPage->save();

        /* menu pelanggan info */
        $dataSubscriber = new Menu;
        $dataSubscriber->name = 'Pelanggan Info';
        $dataSubscriber->description = 'Menu pengaturan pelanggan info';
        $dataSubscriber->route_name = 'subscribers';
        $dataSubscriber->order = ($dataPage->order + 1);
        $dataSubscriber->status = 1;
        $dataSubscriber->parent_id = $data->id;
        $dataSubscriber->index = 1;
        $dataSubscriber->create = 0;
        $dataSubscriber->read = 0;
        $dataSubscriber->update = 1;
        $dataSubscriber->delete = 1;
        $dataSubscriber->save();

        /* menu situs (grup) */
        /* $site = new Menu;
        $site->name = 'Situs';
        $site->description = 'Grup menu situs';
        $site->order = ($data->order + 1);
        $site->status = 1;
        $site->save(); */

        /* menu spanduk */
        /* $siteBanner = new Menu;
        $siteBanner->name = 'Spanduk';
        $siteBanner->description = 'Menu pengaturan spanduk';
        $siteBanner->route_name = 'banners';
        $siteBanner->order = 1;
        $siteBanner->status = 1;
        $siteBanner->parent_id = $site->id;
        $siteBanner->index = 1;
        $siteBanner->create = 1;
        $siteBanner->read = 0;
        $siteBanner->update = 1;
        $siteBanner->delete = 1;
        $siteBanner->save(); */

        /* menu artikel */
        /* $sitePost = new Menu;
        $sitePost->name = 'Artikel';
        $sitePost->description = 'Menu pengaturan artikel';
        $sitePost->route_name = 'posts';
        $sitePost->order = ($siteBanner->order + 1);
        $sitePost->status = 1;
        $sitePost->parent_id = $site->id;
        $sitePost->index = 1;
        $sitePost->create = 1;
        $sitePost->read = 1;
        $sitePost->update = 1;
        $sitePost->delete = 1;
        $sitePost->save(); */

        /* menu halaman */
        /* $sitePage = new Menu;
        $sitePage->name = 'Halaman';
        $sitePage->description = 'Menu pengaturan halaman';
        $sitePage->route_name = 'pages';
        $sitePage->order = ($sitePost->order + 1);
        $sitePage->status = 1;
        $sitePage->parent_id = $site->id;
        $sitePage->index = 1;
        $sitePage->create = 1;
        $sitePage->read = 1;
        $sitePage->update = 1;
        $sitePage->delete = 1;
        $sitePage->save(); */

        /* menu galeri (grup) */
        /* $gallery = new Menu;
        $gallery->name = 'Galeri';
        $gallery->description = 'Grup menu galeri';
        $gallery->order = ($sitePage->order + 1);
        $gallery->status = 1;
        $gallery->parent_id = $site->id;
        $gallery->save(); */

        /* menu foto */
        /* $galPhoto = new Menu;
        $galPhoto->name = 'Foto';
        $galPhoto->description = 'Menu pengaturan foto';
        $galPhoto->route_name = 'photos';
        $galPhoto->order = 1;
        $galPhoto->status = 1;
        $galPhoto->parent_id = $gallery->id;
        $galPhoto->index = 1;
        $galPhoto->create = 1;
        $galPhoto->read = 0;
        $galPhoto->update = 1;
        $galPhoto->delete = 1;
        $galPhoto->save(); */

        /* menu video */
        /* $galVideo = new Menu;
        $galVideo->name = 'Video';
        $galVideo->description = 'Menu pengaturan video';
        $galVideo->route_name = 'videos';
        $galVideo->order = ($galPhoto->order + 1);
        $galVideo->status = 1;
        $galVideo->parent_id = $gallery->id;
        $galVideo->index = 1;
        $galVideo->create = 1;
        $galVideo->read = 0;
        $galVideo->update = 1;
        $galVideo->delete = 1;
        $galVideo->save(); */

        /* menu laporan (grup) */
        $report = new Menu;
        $report->name = 'Laporan';
        $report->description = 'Grup menu laporan';
        $report->order = ($data->order + 1);
        $report->status = 1;
        $report->save();

        /* menu kontak masuk */
        $repInbox = new Menu;
        $repInbox->name = 'Kontak Masuk';
        $repInbox->description = 'Menu pengaturan kontak masuk';
        $repInbox->route_name = 'inbox';
        $repInbox->order = 1;
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
        $repComment->order = ($repInbox->order + 1);
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
        $repInterm->order = ($repComment->order + 1);
        $repInterm->status = 1;
        $repInterm->parent_id = $report->id;
        $repInterm->index = 1;
        $repInterm->create = 0;
        $repInterm->read = 0;
        $repInterm->update = 0;
        $repInterm->delete = 0;
        $repInterm->save();
    }
}
