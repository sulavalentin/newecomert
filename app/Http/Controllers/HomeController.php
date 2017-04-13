<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Itemssubmenu;
use App\Products;
use App\Slideshow;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function home(Products $products,  Slideshow $slideshow)
    {
        $homepage=$products->getHomeproducts();
        $arr=[];
        foreach($homepage as $key => $item)
        {
            $arr[$item->menu_name][$item->submenu_name][$item->item_name] = ["id"=>$item->id,"count"=>$item->count];
            $return=$products->getLimit($item->submenu_id);
            if(count($return) > 0){
                $arr[$item->menu_name][$item->submenu_name][0]=$products->getLimit($item->submenu_id);
            }
        }
        return view('home',["post"=>$arr,
                            "slideshow"=>$slideshow->getSlideshow(),
                            ]);
    }
    public function produse(Request $request,Itemssubmenu $item,$ordon, $id_submenu , $den , $pag )
    {
        $input = $request->all();
        if(count($input)>=1){
            return view("produse",["produse"=>$item->getProductsWithParameters($input,$id_submenu,$pag, $ordon),
                               "link"=>$item->getLink($id_submenu,$ordon),
                               "sortare"=>$item->getSortareWithParameters($input,$id_submenu),
                               "paginare"=>$item->getPaginareWithParameters($input,$id_submenu),
                               "curentpage"=>$pag,
                               "url"=>$item->createUrl($input)]);
        }else{
            return view("produse",["produse"=>$item->getProducts($id_submenu , $pag , $ordon),
                               "link"=>$item->getLink($id_submenu,$ordon),
                               "sortare"=>$item->getSortare($id_submenu),
                               "paginare"=>$item->getPaginare($id_submenu),
                               "curentpage"=>$pag,
                               "url"=>""]);
        }
    }
    public function oneprodus(Itemssubmenu $item , $id_item)
    {
        return view("article",["item"=>$item->getItem($id_item),
                               "link"=>$item->getDenumireItems($id_item),
                               "images"=>$item->getImages($id_item),
                               "asemanatoare"=>$item->getAsemanatoare($id_item),
                               "descriere"=>$item->getDescription($id_item),
                               "comentarii"=>$item->getComentarii($id_item)
                ]);
    }
    public function addcomentariu(Request $request){
        $id=DB::table("coments")->insertGetId(
                    [
                        "product_id"=>$request->id,
                        "nume"=>$request->nume,
                        "comentariu"=>$request->comentariu,
                        "created_at"=>carbon::now()
                    ]);
        $return=DB::table("coments")->where("id",$id)->first();
        $return->created_at=date('d-m-Y', strtotime($return->created_at));
        return response()->json($return);
                
    }
    public function menu($id)
    {
        $response=DB::table("submenu")
                ->where("menu_id",$id)
                ->get();
        $name=DB::table("menu")
                ->where("id",$id)
                ->value("menu_name");
        return view('menuSubmenu',["response"=>$response,"name"=>$name]);
    }
    public function submenu($id)
    {
        $response=DB::table("itemssubmenu")
                ->where("submenu_id",$id)
                ->get();
        $name=DB::table("submenu")
                ->where("id",$id)
                ->value("submenu_name");
        return view('menuItems',["response"=>$response,"name"=>$name]);
    }
    public function test()
    {
        DB::select("INSERT INTO `admin` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`,`confirmed`) VALUES
                    (1, 'valentin', 'sula.valentin@gmail.com', '$2y$10$8fMGvlWC6Ku56VPJ6//BVe1wehtq4/qLIU2KvWyuKCF48Ul81oju6',  '2016-11-26 12:16:32', '2016-11-26 12:16:32',1);");
        DB::select("INSERT INTO `images` (`id`, `address`, `product_id`, `default`) VALUES
                    (25, 'img/products/items/1.jpg', 1, 1),
                    (26, 'img/products/items/26.jpg', 1, 0),
                    (28, 'img/products/items/28.jpg', 1, 0),
                    (29, 'img/products/items/29.jpg', 1, 0),
                    (30, 'img/products/items/30.jpg', 1, 0),
                    (38, 'img/products/items/31.jpg', 2, 1),
                    (39, 'img/products/items/39.jpg', 2, 0),
                    (41, 'img/products/items/40.jpg', 3, 0),
                    (42, 'img/products/items/42.jpg', 3, 1),
                    (43, 'img/products/items/43.jpg', 4, 1),
                    (44, 'img/products/items/44.jpg', 5, 1),
                    (45, 'img/products/items/45.jpg', 5, 0),
                    (46, 'img/products/items/46.jpg', 6, 1),
                    (47, 'img/products/items/47.jpg', 6, 0),
                    (48, 'img/products/items/48.jpg', 6, 0),
                    (49, 'img/products/items/49.jpg', 7, 0),
                    (50, 'img/products/items/50.jpg', 7, 0),
                    (51, 'img/products/items/51.jpg', 7, 1),
                    (52, 'img/products/items/52.jpg', 8, 1),
                    (53, 'img/products/items/53.jpg', 8, 0),
                    (54, 'img/products/items/54.jpg', 8, 0),
                    (55, 'img/products/items/55.jpg', 8, 0),
                    (56, 'img/products/items/56.jpg', 9, 1),
                    (57, 'img/products/items/57.jpg', 10, 0),
                    (58, 'img/products/items/58.jpg', 10, 0),
                    (59, 'img/products/items/59.jpg', 10, 1),
                    (61, 'img/products/items/60.jpg', 11, 1),
                    (62, 'img/products/items/62.jpg', 12, 1),
                    (63, 'img/products/items/63.jpg', 13, 1),
                    (64, 'img/products/items/64.jpg', 14, 1),
                    (65, 'img/products/items/65.jpg', 15, 1),
                    (66, 'img/products/items/66.jpg', 16, 1),
                    (70, 'img/products/items/70.jpg', 17, 1),
                    (71, 'img/products/items/71.jpg', 18, 1),
                    (72, 'img/products/items/72.jpg', 19, 1),
                    (73, 'img/products/items/73.png', 20, 1),
                    (74, 'img/products/items/74.png', 21, 1),
                    (75, 'img/products/items/75.jpg', 21, 0),
                    (76, 'img/products/items/76.jpg', 21, 0),
                    (77, 'img/products/items/77.jpg', 22, 1),
                    (78, 'img/products/items/78.jpg', 23, 1),
                    (79, 'img/products/items/79.jpg', 24, 1),
                    (80, 'img/products/items/80.jpg', 25, 1),
                    (81, 'img/products/items/81.jpg', 26, 1),
                    (82, 'img/products/items/82.jpeg', 27, 0),
                    (83, 'img/products/items/83.jpg', 27, 1),
                    (84, 'img/products/items/84.jpeg', 28, 1),
                    (85, 'img/products/items/85.jpg', 29, 1),
                    (86, 'img/products/items/86.jpg', 30, 1),
                    (87, 'img/products/items/87.jpg', 31, 1),
                    (88, 'img/products/items/88.jpg', 32, 1),
                    (92, 'img/products/items/89.jpg', 33, 1),
                    (93, 'img/products/items/93.jpg', 34, 1),
                    (94, 'img/products/items/94.jpg', 35, 1),
                    (95, 'img/products/items/95.jpg', 36, 1),
                    (96, 'img/products/items/96.jpg', 37, 0),
                    (97, 'img/products/items/97.jpg', 37, 1),
                    (98, 'img/products/items/98.jpg', 37, 0),
                    (99, 'img/products/items/99.jpg', 38, 0),
                    (100, 'img/products/items/100.jpg', 38, 1),
                    (101, 'img/products/items/101.jpg', 39, 0),
                    (102, 'img/products/items/102.jpg', 39, 1),
                    (104, 'img/products/items/103.jpg', 40, 1),
                    (105, 'img/products/items/105.jpg', 40, 0),
                    (106, 'img/products/items/106.jpg', 41, 1),
                    (107, 'img/products/items/107.jpg', 42, 1),
                    (108, 'img/products/items/108.jpg', 43, 1),
                    (109, 'img/products/items/109.jpg', 44, 1),
                    (110, 'img/products/items/110.jpg', 44, 0),
                    (111, 'img/products/items/111.jpg', 45, 1),
                    (112, 'img/products/items/112.jpg', 46, 1),
                    (113, 'img/products/items/113.jpg', 47, 1);
                    ");
        DB::select("INSERT INTO `itemssubmenu` (`id`, `submenu_id`, `item_name`, `item_image`, `item_active`, `created_at`) VALUES
(1, 1, 'Procesor', 'img/itemssubmenu/item1.jpg', 1, '2016-11-25 15:33:06'),
(2, 1, 'HDD', 'img/itemssubmenu/item2.jpg', 1, '2016-11-25 15:37:21'),
(3, 1, 'Memorie Ram', 'img/itemssubmenu/item3.jpg', 1, '2016-11-25 15:36:48'),
(4, 1, 'SSD', 'img/itemssubmenu/item4.jpg', 1, '2016-11-25 15:37:08'),
(5, 1, 'Placi Video', 'img/itemssubmenu/item5.jpg', 1, '2016-11-25 15:37:42'),
(6, 1, 'Placi De Baza', 'img/itemssubmenu/item6.jpg', 1, '2016-11-25 15:37:58'),
(7, 2, 'All In One', 'img/itemssubmenu/item7.jpg', 1, '2016-11-25 15:41:27'),
(8, 2, 'Game Pc', 'img/itemssubmenu/item8.jpg', 1, '2016-11-25 15:41:42'),
(9, 3, 'Tastaturi', 'img/itemssubmenu/item9.jpg', 1, '2016-11-25 15:51:21'),
(10, 3, 'Mouse', 'img/itemssubmenu/item10.jpg', 1, '2016-11-25 15:51:33'),
(11, 3, 'Joystick', 'img/itemssubmenu/item11.jpg', 1, '2016-11-25 15:51:57'),
(12, 4, 'Monitoare', 'img/itemssubmenu/item12.jpg', 1, '2016-11-25 15:52:57'),
(13, 4, 'Boxe', 'img/itemssubmenu/item13.jpg', 1, '2016-11-25 15:53:38'),
(14, 4, 'Casti', 'img/itemssubmenu/item14.jpg', 1, '2016-11-25 16:27:15'),
(15, 4, 'Camere Web', 'img/itemssubmenu/item15.jpg', 1, '2016-11-25 16:27:51'),
(16, 4, 'Scanere', 'img/itemssubmenu/item16.jpg', 1, '2016-11-25 16:28:43'),
(17, 5, 'Compact Discuri', 'img/itemssubmenu/item17.png', 1, '2016-11-25 16:29:34'),
(18, 5, 'Usb Flash', 'img/itemssubmenu/item18.jpeg', 1, '2016-11-25 16:30:09'),
(19, 5, 'Carduri Memorie, MicroSd', 'img/itemssubmenu/item19.jpg', 1, '2016-11-25 16:30:54'),
(20, 5, 'Hdd Externe', 'img/itemssubmenu/item20.jpg', 1, '2016-11-25 16:31:36'),
(21, 6, 'UPS', 'img/itemssubmenu/item21.jpg', 1, '2016-11-25 16:33:20'),
(22, 6, 'Baterii UPS', 'img/itemssubmenu/item22.jpg', 1, '2016-11-25 16:33:46'),
(23, 6, 'Prelungitoare', 'img/itemssubmenu/item23.jpg', 1, '2016-11-25 16:34:41'),
(24, 6, 'Power Bank', 'img/itemssubmenu/item24.jpg', 1, '2016-11-25 16:35:37');
");
        DB::select("INSERT INTO `menu` (`id`, `menu_name`) VALUES
                    (1, 'Calculatoare'),
                    (2, 'Periferice');");
        DB::select("INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
                        (66, '2016_09_24_161505_create_menu_table', 1),
                        (67, '2016_09_24_161545_create_submenu_table', 1),
                        (68, '2016_09_25_135804_create_itemsSubMenu_table', 1),
                        (69, '2016_09_30_113721_create_users_table', 1),
                        (70, '2016_10_04_110923_create_admin_table', 1),
                        (71, '2016_10_28_092024_create_images_table', 1),
                        (72, '2016_11_08_120351_create_specifications_table', 1),
                        (73, '2016_11_08_120458_create_products_table', 1),
                        (74, '2016_11_08_145350_create_specificationGroup_table', 1),
                        (75, '2016_11_09_135710_create_specificationName_table', 1);");
        DB::select("INSERT INTO `products` (`id`, `table_id`, `originalname`, `name`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 'AMD A4-6300', ' , FM2 , 3.7 Ghz , 1 Mb , 65 W , AMD Radeon HD 8370D', '763.90', NULL, NULL),
(2, 1, 'INTEL Celeron G3900', ' , LGA 1151 , 2,8 GHz , 2 Mb , 51 W , Intel HD Graphics 510', '852.00', NULL, NULL),
(3, 1, 'INTEL Pentium G3250', ' , LGA 1150 , 3,2 GHz , 3 Mb , 54 W , Intel HD Graphics', '1310.00', NULL, NULL),
(4, 1, 'INTEL Pentium G3260 Box', ' , LGA 1150 , 3.3 Ghz , 3 Mb , 65 W , Intel HD Graphics', '1488.00', NULL, NULL),
(5, 1, 'AMD A8-7500', ' , FM2 , 3.0-3.7GHz , 6 Mb , 100 W , AMD Radeon R7 Graphics', '1876.00', NULL, NULL),
(6, 1, 'INTEL Core I5-4460', ' , LGA 1150 , 3,2-3,4 GHz , 6 Mb , 84 W , HD Graphics 4600', '4400.00', NULL, NULL),
(7, 1, 'INTEL Core I5-6400', ' , LGA 1151 , 2.7-3.3 GHz , 6 Mb , 65 W , HD Graphics 530', '4575.00', NULL, NULL),
(8, 1, 'INTEL Core I7-6700 Box', ' , LGA 1151 , 3,4-4,0 GHz , 8 Mb , 65 W , HD Graphics 530', '8399.00', NULL, NULL),
(9, 1, 'INTEL Core I7-6900K Box', ' , LGA 2011 , 3,2-3,7 GHz , 20 Mb , 140 W , Fara', '29812.00', NULL, NULL),
(10, 1, 'AMD FX-8370', ' , AM3+ , 4.0 Ghz , 16 Mb , 125 W , -', '3805.25', NULL, NULL),
(11, 2, 'Hard Disk (WD1600AAJS)', ' , WD , 160 GB , 7200 Rpm , 8 MB , SATA II', '661.00', NULL, NULL),
(12, 2, 'Hard Disk (WD2500AVJS)', ' , WD , 250 GB , 7200 Rpm , 8 MB , SATA II', '729.00', NULL, NULL),
(13, 2, 'Hard Disk (WD3200AAJS)', ' , WD , 320 GB , 7200 Rpm , 8 MB , SATA II', '773.00', NULL, NULL),
(14, 2, 'Hard Disk (WD5000AUDX)', ' , WD , 500 GB , 7200 Rpm , 32 MB , SATA III', '998.00', NULL, NULL),
(15, 2, 'Hard Disk Caviar Green (WD5000AAVS)', ' , WD , 500 GB , 7200 Rpm , 8 MB , SATA III', '998.00', NULL, NULL),
(16, 2, 'Hard Disk  WD WD10EURX AV-GP', ' , WD , 1.0 TB , 7200 Rpm , 64 MB , SATA 6Gb/s', '1166.00', NULL, NULL),
(17, 2, 'Hard Disk Red (WD10EFRX)', ' , WD , 1.0 TB , 7200 Rpm , 64 MB , SATA 6Gb/s', '1666.00', NULL, NULL),
(18, 2, 'Hard Disk Ultrastar A7K3000 HUA723020ALA641', ' , HITACHI , 2.0 TB , 7200 Rpm , 64 MB , SATA III', '1774.00', NULL, NULL),
(19, 2, 'Hard Disk (WD20EZRX) Green', ' , WD , 2.0 TB , 7200 Rpm , 64 MB , SATA III', '1888.00', NULL, NULL),
(20, 2, 'Hard Disk Enterprise NAS (ST2000VN0001)', ' , SEAGATE , 2.0 TB , 7200 Rpm , 128 MB , SATA III', '3256.00', NULL, NULL),
(21, 2, 'Hard Disk Enterprise Capacity (Helium)', ' , SEAGATE , 10 TB , 7200 Rpm , 256 MB , SATA 6Gb/s', '15513.00', NULL, NULL),
(22, 2, 'Hard Disk Surveillance (ST3000VX000)', ' , SEAGATE , 3.0 TB , 7200 Rpm , 64 MB , SATA III', '2706.00', NULL, NULL),
(23, 2, 'Hard Disk Surveillance (MD03ACA200V)', ' , TOSHIBA , 2.0 TB , 7200 Rpm , 64 MB , SATA III', '2176.00', NULL, NULL),
(24, 2, 'Hard Disk Surveillance (MD04ABA400V)', ' , TOSHIBA , 4.0 TB , 7200 Rpm , 128 MB , SATA III', '3960.00', NULL, NULL),
(25, 2, 'Hard Disk Data Storage (MD04ACA400)', ' , TOSHIBA , 4.0 TB , 7200 Rpm , 128 MB , SATA 6Gb/s', '3586.00', NULL, NULL),
(26, 2, 'Hard Disk Ultrastar A7K2000 HUA722020ALA330 (0F10452)', ' , HITACHI , 2.0 TB , 7200 Rpm , 32 MB , SATA II', '1654.00', NULL, NULL),
(27, 2, 'Hard Disk Purple (WD80PUZX)', ' , HITACHI , 8.0 TB , 5400 Rpm , 128 MB , SATA III', '8933.00', NULL, NULL),
(28, 3, 'PC12800', ' , GEIL , DDR3 , 2 Gb , 1600 MHz', '342.00', NULL, NULL),
(29, 3, 'Original PC12800', ' , SAMSUNG , DDR3 , 2 Gb , 1600 MHz', '354.00', NULL, NULL),
(30, 3, 'PC12800', ' , GEIL , DDR3 , 4 Gb , 1600 MHz', '559.00', NULL, NULL),
(31, 3, 'Original PC12800', ' , SAMSUNG , DDR3 , 4 Gb , 1600 MHz', '582.00', NULL, NULL),
(32, 3, 'Original PC12800', ' , HYNIX , DDR3L , 4 Gb , 1600 MHz', '582.00', NULL, NULL),
(33, 3, 'Original PC17000', ' , HYNIX , DDR4 , 4 Gb , 2133 MHz', '645.00', NULL, NULL),
(34, 3, 'PC6400', ' , Team Group , DDR2 , 2 Gb , 800 MHz', '667.00', NULL, NULL),
(35, 3, 'PC12800', ' , Goldkey , DDR3 , 8 Gb , 1600 MHz', '1029.00', NULL, NULL),
(36, 3, 'Pristine Series PC19200', ' , GEIL , DDR4 , 8 Gb , 2400 MHz', '1144.00', NULL, NULL),
(37, 3, 'HyperX FURY HX316C10FB/8 Black', ' , KINGSTON , DDR3 , 8 Gb , 1600 MHz', '1166.00', NULL, NULL),
(38, 3, 'AXeRam TX2400KLU-4GK', ' , TRANSCEND , DDR3 , 4 Gb , 2400 MHz', '1499.00', NULL, NULL),
(39, 3, 'HyperX Savage HX430C15SB2K2/16', ' , KINGSTON , DDR4 , 16 GB , 3000 MHz', '3290.00', NULL, NULL),
(40, 3, 'HyperX Savage HX426C15SBK2/32', ' , KINGSTON , DDR4 , 32 GB , 2666 MHz', '5251.00', NULL, NULL),
(41, 4, 'Goldkey GKH84', ' , 32 GB , 550 MB/s', '639.00', NULL, NULL),
(42, 4, 'SSD370', ' , 32 GB , 570 MB/s', '751.00', NULL, NULL),
(43, 4, 'Dark L3', ' , 60 GB , 450 Mb/s.', '886.00', NULL, NULL),
(44, 4, 'TS64GMTS800', ' , 64 GB , 570 MB/s', '930.00', NULL, NULL),
(45, 4, 'L7 Evo (T253L7120GTC101)', ' , 120 GB , 530 МB/s', '1110.00', NULL, NULL),
(46, 4, 'SX930 XPG', ' , 240 GB , 560 MB/s', '2442.00', NULL, NULL),
(47, 4, 'SM961', ' , 1.0 TB , 3200 MB/s', '12637.00', NULL, NULL);
");
        DB::select("INSERT INTO `specificationgroup` (`id`, `table_id`, `name_group`) VALUES
                    (1, 1, 'Caracteristici generale'),
                    (2, 1, 'Informatii suplimentare'),
                    (3, 1, 'Grafica'),
                    (4, 2, 'Caracteristicele dispozitivului de stocare'),
                    (5, 2, 'Interfete'),
                    (6, 2, 'Altele'),
                    (7, 3, 'Caracteristici tehnice'),
                    (8, 3, 'Timing'),
                    (9, 3, 'Alimentarea'),
                    (10, 4, 'Caracteristici generale'),
                    (11, 4, 'Interfeţe');");
        DB::select("INSERT INTO `specificationname` (`id`, `table_id`, `group_id`, `specification_name`, `addname`, `addsearch`) VALUES
(2, 1, 1, 'Garantie', 0, 0),
(3, 1, 1, 'Socket', 1, 1),
(4, 1, 1, 'Frecventa', 1, 0),
(5, 1, 1, 'Numarul nucleelor', 0, 1),
(6, 1, 1, 'Procesul tehnic', 0, 0),
(7, 1, 1, 'Mod operare', 0, 0),
(8, 1, 1, 'Cache L3', 1, 1),
(9, 1, 1, 'Capacitate maxim memorie', 0, 0),
(10, 1, 2, 'Cooler', 0, 1),
(11, 1, 2, 'Consum', 1, 0),
(12, 1, 3, 'Suport grafic', 0, 1),
(13, 1, 3, 'Model', 1, 0),
(14, 1, 3, 'Frecventa', 0, 0),
(15, 1, 1, 'Producator', 0, 1),
(16, 2, 4, 'Producator', 1, 1),
(17, 2, 4, 'Memorie de stocare', 1, 1),
(18, 2, 4, 'Viteza de rotatie', 1, 1),
(19, 2, 4, 'Buffer', 1, 0),
(20, 2, 4, 'Timp de initializare', 0, 0),
(21, 2, 5, 'Interfata unitatii de stocare', 1, 1),
(22, 2, 5, 'Suport NCQ', 0, 0),
(23, 2, 6, 'Garantie', 0, 0),
(24, 2, 6, 'Destinatie', 0, 1),
(25, 2, 6, 'Form-factor', 0, 1),
(26, 3, 7, 'Producator', 1, 1),
(27, 3, 7, 'Tipul de memorie', 1, 1),
(28, 3, 7, 'Standardul memoriei', 0, 0),
(29, 3, 7, 'Form-factor memorie', 0, 0),
(30, 3, 7, 'Cantitatea de module în complet', 0, 0),
(31, 3, 7, 'Capacitate memorie', 1, 1),
(32, 3, 8, 'CAS-latența', 0, 0),
(33, 3, 9, 'Tensiune electrică', 0, 0),
(34, 3, 7, 'Frecvenţa memorie', 1, 0),
(35, 4, 10, 'Producator', 0, 1),
(36, 4, 10, 'Garantie', 0, 0),
(37, 4, 10, 'Memorie de stocare', 1, 1),
(38, 4, 10, 'Controler', 0, 0),
(39, 4, 10, 'Tipul cipurilor', 0, 0),
(40, 4, 10, 'Viteza citire', 1, 0),
(41, 4, 10, 'Viteza scriere', 0, 0),
(43, 4, 11, 'Interfața unității de stocare', 0, 1);
");
        DB::select("INSERT INTO `specifications` (`id`, `product_id`, `specification_id`, `value`) VALUES
(2, 1, 2, '36 luni'),
(3, 1, 3, 'FM2'),
(4, 1, 4, '3.7 Ghz'),
(5, 1, 5, '2'),
(6, 1, 6, '32 nm'),
(7, 1, 7, '64 biti'),
(8, 1, 8, '1 Mb'),
(9, 1, 9, '64 Gb'),
(10, 1, 10, 'da'),
(11, 1, 11, '65 W'),
(12, 1, 12, 'da'),
(13, 1, 13, 'AMD Radeon HD 8370D'),
(14, 1, 14, '760 Mhz'),
(15, 1, 15, 'Amd'),
(16, 2, 2, '12 luni'),
(17, 2, 3, 'LGA 1151'),
(18, 2, 4, '2,8 GHz'),
(19, 2, 5, '2'),
(20, 2, 6, '14 nm'),
(21, 2, 7, '64 biti'),
(22, 2, 8, '2 Mb'),
(23, 2, 9, '64 Gb'),
(24, 2, 15, 'Intel'),
(25, 2, 10, 'nu'),
(26, 2, 11, '51 W'),
(27, 2, 12, 'da'),
(28, 2, 13, 'Intel HD Graphics 510'),
(29, 2, 14, '350 MHz (950 MHz Turbo Boost)'),
(30, 3, 2, '12 luni'),
(31, 3, 3, 'LGA 1150'),
(32, 3, 4, '3,2 GHz'),
(33, 3, 5, '2'),
(34, 3, 6, '14 nm'),
(35, 3, 7, '64 biti'),
(36, 3, 8, '3 Mb'),
(37, 3, 9, '64 Gb'),
(38, 3, 15, 'Intel'),
(39, 3, 10, 'nu'),
(40, 3, 11, '54 W'),
(41, 3, 12, 'da'),
(42, 3, 13, 'Intel HD Graphics'),
(43, 3, 14, '350 MHz (1.1 Turbo)'),
(44, 4, 2, '12 luni'),
(45, 4, 3, 'LGA 1150'),
(46, 4, 4, '3.3 Ghz'),
(47, 4, 5, '2'),
(48, 4, 6, '14 nm'),
(49, 4, 7, '64 biti'),
(50, 4, 8, '3 Mb'),
(51, 4, 9, '64 Gb'),
(52, 4, 15, 'Intel'),
(53, 4, 10, 'da'),
(54, 4, 11, '65 W'),
(55, 4, 12, 'da'),
(56, 4, 13, 'Intel HD Graphics'),
(57, 4, 14, '350 MHz (1.1 Turbo)'),
(58, 5, 2, '12 luni'),
(59, 5, 3, 'FM2'),
(60, 5, 4, '3.0-3.7GHz'),
(61, 5, 5, '4'),
(62, 5, 6, '28 nm'),
(63, 5, 7, '64 biti'),
(64, 5, 8, '6 Mb'),
(65, 5, 9, '64 Gb'),
(66, 5, 15, 'Amd'),
(67, 5, 10, 'nu'),
(68, 5, 11, '100 W'),
(69, 5, 12, 'da'),
(70, 5, 13, 'AMD Radeon R7 Graphics'),
(71, 5, 14, '785 Mhz'),
(72, 6, 2, '12 luni'),
(73, 6, 3, 'LGA 1150'),
(74, 6, 4, '3,2-3,4 GHz'),
(75, 6, 5, '4'),
(76, 6, 6, '22 nm'),
(77, 6, 7, '64 biti'),
(78, 6, 8, '6 Mb'),
(79, 6, 9, '32 Gb'),
(80, 6, 15, 'Intel'),
(81, 6, 10, 'nu'),
(82, 6, 11, '84 W'),
(83, 6, 12, 'da'),
(84, 6, 13, 'HD Graphics 4600'),
(85, 6, 14, '350 MHz (1.1 Turbo)'),
(86, 7, 2, '12 luni'),
(87, 7, 3, 'LGA 1151'),
(88, 7, 4, '2.7-3.3 GHz'),
(89, 7, 5, '4'),
(90, 7, 6, '14 nm'),
(91, 7, 7, '64 biti'),
(92, 7, 8, '6 Mb'),
(93, 7, 9, '64 Gb'),
(94, 7, 15, 'Intel'),
(95, 7, 10, 'da'),
(96, 7, 11, '65 W'),
(97, 7, 12, 'da'),
(98, 7, 13, 'HD Graphics 530'),
(99, 7, 14, '350 MHz'),
(100, 8, 2, '12 luni'),
(101, 8, 3, 'LGA 1151'),
(102, 8, 4, '3,4-4,0 GHz'),
(103, 8, 5, '4'),
(104, 8, 6, '22 nm'),
(105, 8, 7, '64 biti'),
(106, 8, 8, '8 Mb'),
(107, 8, 9, '64 Gb'),
(108, 8, 15, 'Intel'),
(109, 8, 10, 'da'),
(110, 8, 11, '65 W'),
(111, 8, 12, 'da'),
(112, 8, 13, 'HD Graphics 530'),
(113, 8, 14, '350 MHz (1.15 Turbo)'),
(114, 9, 2, '12 luni'),
(115, 9, 3, 'LGA 2011'),
(116, 9, 4, '3,2-3,7 GHz'),
(117, 9, 5, '8'),
(118, 9, 6, '14 nm'),
(119, 9, 7, '64 biti'),
(120, 9, 8, '20 Mb'),
(121, 9, 9, '128 Gb'),
(122, 9, 15, 'Intel'),
(123, 9, 10, 'da'),
(124, 9, 11, '140 W'),
(125, 9, 12, 'nu'),
(126, 9, 13, 'fara'),
(127, 9, 14, ''),
(128, 10, 2, '12 luni'),
(129, 10, 3, 'AM3+'),
(130, 10, 4, '4.0 Ghz'),
(131, 10, 5, '8'),
(132, 10, 6, '32 nm'),
(133, 10, 7, '64 biti'),
(134, 10, 8, '16 Mb'),
(135, 10, 9, '64 Gb'),
(136, 10, 15, 'Amd'),
(137, 10, 10, 'da'),
(138, 10, 11, '125 W'),
(139, 10, 12, 'nu'),
(140, 10, 13, '-'),
(142, 11, 16, 'WD'),
(143, 11, 17, '160 GB'),
(144, 11, 18, '7200 rpm'),
(145, 11, 19, '8 MB'),
(147, 11, 21, 'SATA II'),
(149, 11, 23, '3 ani'),
(150, 11, 24, 'pentru computere personale'),
(151, 11, 25, '3,5'),
(152, 12, 16, 'WD'),
(153, 12, 17, '250 GB'),
(154, 12, 18, '7200 rpm'),
(155, 12, 19, '8 MB'),
(157, 12, 21, 'SATA II'),
(158, 12, 22, '+'),
(159, 12, 23, 'pentru media-centre'),
(160, 12, 24, 'pentru computere personale'),
(161, 12, 25, '3,5'),
(162, 13, 16, 'WD'),
(163, 13, 17, '320 GB'),
(164, 13, 18, '7200 rpm'),
(165, 13, 19, '8 MB'),
(166, 13, 20, ''),
(167, 13, 21, 'SATA II'),
(168, 13, 22, ''),
(169, 13, 23, '3 ani'),
(170, 13, 24, 'pentru computere personale'),
(171, 13, 25, '3,5'),
(172, 14, 16, 'WD'),
(173, 14, 17, '500 GB'),
(174, 14, 18, '7200 rpm'),
(175, 14, 19, '32 MB'),
(176, 14, 20, ''),
(177, 14, 21, 'SATA III'),
(178, 14, 22, ''),
(179, 14, 23, '3 ani'),
(180, 14, 24, 'pentru computere personale'),
(181, 14, 25, '3,5'),
(182, 15, 16, 'WD'),
(183, 15, 17, '500 GB'),
(184, 15, 18, '7200 rpm'),
(185, 15, 19, '8 MB'),
(186, 15, 20, ''),
(187, 15, 21, 'SATA III'),
(188, 15, 22, ''),
(189, 15, 23, '3 ani'),
(190, 15, 24, 'pentru computere personale'),
(191, 15, 25, '2.5'),
(192, 16, 16, 'WD'),
(193, 16, 17, '1.0 TB'),
(194, 16, 18, '7200 rpm'),
(195, 16, 19, '64 MB'),
(197, 16, 21, 'SATA 6Gb/s'),
(199, 16, 23, '3 ani'),
(200, 16, 24, 'pentru sisteme de securitate'),
(201, 16, 25, '3,5'),
(202, 17, 16, 'WD'),
(203, 17, 17, '1.0 TB'),
(204, 17, 18, '7200 rpm'),
(205, 17, 19, '64 MB'),
(207, 17, 21, 'SATA 6Gb/s'),
(209, 17, 23, '3 ani'),
(210, 17, 24, 'pentru computere personale'),
(211, 17, 25, '3,5'),
(212, 18, 16, 'HITACHI'),
(213, 18, 17, '2.0 TB'),
(214, 18, 18, '7200 rpm'),
(215, 18, 19, '64 MB'),
(216, 18, 20, ''),
(217, 18, 21, 'SATA III'),
(218, 18, 22, ''),
(219, 18, 23, '3 ani'),
(220, 18, 24, 'pentru computere personale'),
(221, 18, 25, '3,5'),
(222, 19, 16, 'WD'),
(223, 19, 17, '2.0 TB'),
(224, 19, 18, '7200 rpm'),
(225, 19, 19, '64 MB'),
(226, 19, 20, ''),
(227, 19, 21, 'SATA III'),
(228, 19, 22, ''),
(229, 19, 23, '3 ani'),
(230, 19, 24, 'pentru computere personale'),
(231, 19, 25, '3,5'),
(232, 20, 16, 'SEAGATE'),
(233, 20, 17, '2.0 TB'),
(234, 20, 18, '7200 rpm'),
(235, 20, 19, '128 MB'),
(236, 20, 20, ''),
(237, 20, 21, 'SATA III'),
(238, 20, 22, ''),
(239, 20, 23, '2 ani'),
(240, 20, 24, 'pentru computere personale'),
(241, 20, 25, '2.5'),
(242, 21, 16, 'SEAGATE'),
(243, 21, 17, '10 TB'),
(244, 21, 18, '7200 rpm'),
(245, 21, 19, '256 MB'),
(247, 21, 21, 'SATA 6Gb/s'),
(249, 21, 23, '2 ani'),
(250, 21, 24, 'pentru servere'),
(251, 21, 25, '3,5'),
(252, 22, 16, 'SEAGATE'),
(253, 22, 17, '3.0 TB'),
(254, 22, 18, '7200 rpm'),
(255, 22, 19, '64 MB'),
(256, 22, 20, ''),
(257, 22, 21, 'SATA III'),
(258, 22, 22, '+'),
(259, 22, 23, '3 ani'),
(260, 22, 24, 'pentru computere personale'),
(261, 22, 25, '3,5'),
(262, 23, 16, 'TOSHIBA'),
(263, 23, 17, '2.0 TB'),
(264, 23, 18, '7200 rpm'),
(265, 23, 19, '64 MB'),
(266, 23, 20, ''),
(267, 23, 21, 'SATA III'),
(268, 23, 22, ''),
(269, 23, 23, '2 ani'),
(270, 23, 24, 'pentru computere personale'),
(271, 23, 25, '3,5'),
(272, 24, 16, 'TOSHIBA'),
(273, 24, 17, '4.0 TB'),
(274, 24, 18, '7200 rpm'),
(275, 24, 19, '128 MB'),
(276, 24, 20, ''),
(277, 24, 21, 'SATA III'),
(278, 24, 22, ''),
(279, 24, 23, '2 ani'),
(280, 24, 24, 'pentru computere personale'),
(281, 24, 25, '3,5'),
(282, 25, 16, 'TOSHIBA'),
(283, 25, 17, '4.0 TB'),
(284, 25, 18, '7200 rpm'),
(285, 25, 19, '128 MB'),
(287, 25, 21, 'SATA 6Gb/s'),
(289, 25, 23, '2 ani'),
(290, 25, 24, 'pentru computere personale'),
(291, 25, 25, '3,5'),
(292, 26, 16, 'HITACHI'),
(293, 26, 17, '2.0 TB'),
(294, 26, 18, '7200 rpm'),
(295, 26, 19, '32 MB'),
(296, 26, 20, ''),
(297, 26, 21, 'SATA II'),
(298, 26, 22, ''),
(299, 26, 23, '2 ani'),
(300, 26, 24, 'pentru computere personale'),
(301, 26, 25, '3,5'),
(302, 27, 16, 'HITACHI'),
(303, 27, 17, '8.0 TB'),
(304, 27, 18, '5400 rpm'),
(305, 27, 19, '128 MB'),
(307, 27, 21, 'SATA III'),
(309, 27, 23, '3 ani'),
(310, 27, 24, 'pentru sisteme de securitate'),
(311, 27, 25, '3,5'),
(312, 28, 26, 'GEIL'),
(313, 28, 27, 'DDR3'),
(314, 28, 28, 'PC3-12800'),
(315, 28, 29, 'DIMM'),
(316, 28, 30, '1'),
(317, 28, 31, '2 Gb'),
(318, 28, 34, '1600 MHz'),
(319, 28, 32, 'CL11'),
(320, 28, 33, '1,5 V'),
(321, 29, 26, 'SAMSUNG'),
(322, 29, 27, 'DDR3'),
(323, 29, 28, 'PC3-12800'),
(324, 29, 29, 'DIMM'),
(325, 29, 30, '1'),
(326, 29, 31, '2 Gb'),
(327, 29, 34, '1600 MHz'),
(328, 29, 32, 'CL11'),
(329, 29, 33, '1,5 V'),
(330, 30, 26, 'GEIL'),
(331, 30, 27, 'DDR3'),
(332, 30, 28, 'PC3-12800'),
(333, 30, 29, 'DIMM'),
(334, 30, 30, '1'),
(335, 30, 31, '4 Gb'),
(336, 30, 34, '1600 MHz'),
(337, 30, 32, 'CL11'),
(338, 30, 33, '1,5 V'),
(339, 31, 26, 'SAMSUNG'),
(340, 31, 27, 'DDR3'),
(341, 31, 28, 'PC3-12800'),
(342, 31, 29, 'DIMM'),
(343, 31, 30, '1'),
(344, 31, 31, '4 Gb'),
(345, 31, 34, '1600 MHz'),
(346, 31, 32, 'CL11'),
(347, 31, 33, '1,5 V'),
(348, 32, 26, 'HYNIX'),
(349, 32, 27, 'DDR3L'),
(350, 32, 28, 'PC3-12800'),
(351, 32, 29, 'DIMM'),
(352, 32, 30, '1'),
(353, 32, 31, '4 Gb'),
(354, 32, 34, '1600 MHz'),
(355, 32, 32, 'CL11'),
(356, 32, 33, '1,35 V'),
(357, 33, 26, 'HYNIX'),
(358, 33, 27, 'DDR4'),
(359, 33, 28, 'PC17000'),
(360, 33, 29, 'DIMM'),
(361, 33, 30, '1'),
(362, 33, 31, '4 Gb'),
(363, 33, 34, '2133 MHz'),
(364, 33, 32, 'CL15'),
(365, 33, 33, '1,2 V'),
(366, 34, 26, 'Team Group'),
(367, 34, 27, 'DDR2'),
(368, 34, 28, 'PC2-6400'),
(369, 34, 29, 'DIMM'),
(370, 34, 30, '1'),
(371, 34, 31, '2 Gb'),
(372, 34, 34, '800 MHz'),
(373, 34, 32, 'CL5'),
(374, 34, 33, ''),
(375, 35, 26, 'Goldkey'),
(376, 35, 27, 'DDR3'),
(377, 35, 28, 'PC3-12800'),
(378, 35, 29, 'DIMM'),
(379, 35, 30, '1'),
(380, 35, 31, '8 Gb'),
(381, 35, 34, '1600 MHz'),
(382, 35, 32, 'CL11'),
(383, 35, 33, ''),
(384, 36, 26, 'GEIL'),
(385, 36, 27, 'DDR4'),
(386, 36, 28, 'PC4-19200'),
(387, 36, 29, 'DIMM'),
(388, 36, 30, '1'),
(389, 36, 31, '8 Gb'),
(390, 36, 34, '2400 MHz'),
(391, 36, 32, 'CL16'),
(392, 36, 33, '1,2 V'),
(393, 37, 26, 'KINGSTON'),
(394, 37, 27, 'DDR3'),
(395, 37, 28, 'PC3-12800'),
(396, 37, 29, 'DIMM'),
(397, 37, 30, '1'),
(398, 37, 31, '8 Gb'),
(399, 37, 34, '1600 MHz'),
(400, 37, 32, 'CL10'),
(401, 37, 33, '1,5 V'),
(402, 38, 26, 'TRANSCEND'),
(403, 38, 27, 'DDR3'),
(404, 38, 28, 'PC3-19200'),
(405, 38, 29, 'DIMM'),
(406, 38, 30, '2'),
(407, 38, 31, '4 Gb'),
(408, 38, 34, '2400 MHz'),
(409, 38, 32, 'CL11'),
(410, 38, 33, '1,65 V'),
(411, 39, 26, 'KINGSTON'),
(412, 39, 27, 'DDR4'),
(413, 39, 28, 'PC24000'),
(414, 39, 29, 'DIMM'),
(415, 39, 30, '2'),
(416, 39, 31, '16 GB'),
(417, 39, 34, '3000 MHz'),
(418, 39, 32, 'CL15'),
(419, 39, 33, '1,35 V'),
(420, 40, 26, 'KINGSTON'),
(421, 40, 27, 'DDR4'),
(422, 40, 28, 'PC21300'),
(423, 40, 29, 'DIMM'),
(424, 40, 30, '2'),
(425, 40, 31, '32 GB'),
(426, 40, 34, '2666 MHz'),
(427, 40, 32, 'CL15'),
(428, 40, 33, '1,2 V'),
(429, 41, 35, 'Goldkey'),
(430, 41, 36, '36 luni'),
(431, 41, 37, '32 GB'),
(432, 41, 38, 'SM2246EN'),
(433, 41, 39, 'MLC NAND Flash memory'),
(434, 41, 40, '550 MB/s'),
(435, 41, 41, '450 MB/s'),
(436, 41, 43, 'SATA III'),
(437, 42, 35, 'TRANSCEND'),
(438, 42, 36, '36 luni'),
(439, 42, 37, '32 GB'),
(440, 42, 38, 'MLC NAND (Multi Level Cell)'),
(441, 42, 39, ''),
(442, 42, 40, '570 MB/s'),
(443, 42, 41, '470 MB/s'),
(444, 42, 43, 'SATA III'),
(445, 43, 35, 'Team Group'),
(446, 43, 36, '36 luni'),
(447, 43, 37, '60 GB'),
(448, 43, 38, 'Phison PS3110-S10'),
(449, 43, 39, 'MLC (Multi Level Cell)'),
(450, 43, 40, '450 Mb/s.'),
(451, 43, 41, '550 MB/s'),
(452, 43, 43, 'SATA III'),
(453, 44, 35, 'TRANSCEND'),
(454, 44, 36, '36 luni'),
(455, 44, 37, '64 GB'),
(456, 44, 38, ''),
(457, 44, 39, 'MLC NAND (Multi Level Cell)'),
(458, 44, 40, '570 MB/s'),
(459, 44, 41, '460 MB/s'),
(460, 44, 43, 'M.2'),
(461, 45, 35, 'Team Group'),
(462, 45, 36, '36 luni'),
(463, 45, 37, '120 GB'),
(464, 45, 38, ''),
(465, 45, 39, ''),
(466, 45, 40, '530 МB/s'),
(467, 45, 41, '360 MB/s'),
(468, 45, 43, 'SATA III'),
(469, 46, 35, 'ADATA'),
(470, 46, 36, '36 luni'),
(471, 46, 37, '240 GB'),
(472, 46, 38, 'JMicron JMF670H'),
(473, 46, 39, 'Synchronous MLC Plus'),
(474, 46, 40, '560 MB/s'),
(475, 46, 41, '460 MB/s'),
(476, 46, 43, 'SATA 6Gb/s'),
(477, 47, 35, 'SAMSUNG'),
(478, 47, 36, '36 luni'),
(479, 47, 37, '1.0 TB'),
(480, 47, 38, 'Samsung Polaris'),
(481, 47, 39, '3D V-NAND MLC'),
(482, 47, 40, '3200 MB/s'),
(483, 47, 41, '1800 MB/s'),
(484, 47, 43, 'M.2 PCIe');");
        DB::select("INSERT INTO `submenu` (`id`, `submenu_name`, `submenu_image`, `submenu_active`, `menu_id`) VALUES
(1, 'Componente', 'img/submenu/sub1.jpg', 1, 1),
(2, 'Calculatoare', 'img/submenu/sub2.jpg', 1, 1),
(3, 'Dispozitive De Intrare', 'img/submenu/sub3.jpg', 1, 2),
(4, 'Multimedia', 'img/submenu/sub4.jpg', 1, 2),
(5, 'Uniti De Stocare', 'img/submenu/sub5.jpg', 1, 2),
(6, 'Alimentare Electric', 'img/submenu/sub6.jpg', 1, 2);");
        return view("test");
    }
}
