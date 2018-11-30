<?php

namespace App\Http\Controllers;

use App\Foto;
use App\Perusahaan;
use App\Supports\OpenStreetMaps;
use App\Toko;
use Illuminate\Http\Request;

class TokoController extends Controller
{
    public function index(Request $request)
    {
        $tokos = Toko::query()->when($request->perusahaan, function ($query) use ($request) {
            $query->whereHas('getPerusahaan', function ($query) use ($request){
                $query->where('nama', $request->perusahaan);
            });
        })->when($request->npkk, function ($query) use ($request) {
            foreach (explode('|', $request->npkk) as $npkk){
                $query->where(function ($query) use ($request, $npkk) {
                    $exploded = explode(',', $npkk);

                    $negara = $exploded[0];
                    $provinsi = $exploded[1];
                    $kota = $exploded[2];
                    $kecamatan = $exploded[3];

                    if (!empty($negara))
                        $query->where('negara', 'ILIKE', '%'.$negara.'%');
                    if (!empty($provinsi))
                        $query->where('provinsi', 'ILIKE', '%'.$provinsi.'%');
                    if (!empty($kota))
                        $query->where('kota', 'ILIKE', '%'.$kota.'%');
                    if (!empty($kecamatan))
                        $query->where('kecamatan', 'ILIKE', '%'.$kecamatan.'%');
                });
            }
        })->orderBy('created_at')
            ->paginate(10)
            ->appends($request->all());

        return view('toko', [
            'tokos' => $tokos,
            'perusahaans' => Perusahaan::orderBy('nama')->get(),
            'perusahaan' => $request->perusahaan,
            'npkk' => $request->npkk,
            'kp' => [
                'PANGANDARAN, JAWA BARAT',
                'PUNCAK JAYA, PAPUA',
                'PANIAI, PAPUA',
                'MIMIKA, PAPUA',
                'SARMI, PAPUA',
                'KEEROM, PAPUA',
                'PEGUNUNGAN BINTANG, PAPUA',
                'YAHUKIMO, PAPUA',
                'ACEH SELATAN, NANGGROE ACEH DARUSSALAM',
                'ACEH TENGGARA, NANGGROE ACEH DARUSSALAM',
                'ACEH TIMUR, NANGGROE ACEH DARUSSALAM',
                'ACEH TENGAH, NANGGROE ACEH DARUSSALAM',
                'ACEH BARAT, NANGGROE ACEH DARUSSALAM',
                'ACEH BESAR, NANGGROE ACEH DARUSSALAM',
                'PIDIE, NANGGROE ACEH DARUSSALAM',
                'ACEH UTARA, NANGGROE ACEH DARUSSALAM',
                'SIMEULUE, NANGGROE ACEH DARUSSALAM',
                'ACEH SINGKIL, NANGGROE ACEH DARUSSALAM',
                'BIREUEN, NANGGROE ACEH DARUSSALAM',
                'ACEH BARAT DAYA, NANGGROE ACEH DARUSSALAM',
                'GAYO LUES, NANGGROE ACEH DARUSSALAM',
                'ACEH JAYA, NANGGROE ACEH DARUSSALAM',
                'NAGAN RAYA, NANGGROE ACEH DARUSSALAM',
                'ACEH TAMIANG, NANGGROE ACEH DARUSSALAM',
                'BENER MERIAH, NANGGROE ACEH DARUSSALAM',
                'PIDIE JAYA, NANGGROE ACEH DARUSSALAM',
                'BANDA ACEH, NANGGROE ACEH DARUSSALAM',
                'SABANG, NANGGROE ACEH DARUSSALAM',
                'LHOKSEUMAWE, NANGGROE ACEH DARUSSALAM',
                'LANGSA, NANGGROE ACEH DARUSSALAM',
                'SUBULUSSALAM, NANGGROE ACEH DARUSSALAM',
                'TAPANULI TENGAH, SUMATERA UTARA',
                'TAPANULI UTARA, SUMATERA UTARA',
                'TAPANULI SELATAN, SUMATERA UTARA',
                'NIAS, SUMATERA UTARA',
                'LANGKAT, SUMATERA UTARA',
                'KARO, SUMATERA UTARA',
                'DELI SERDANG, SUMATERA UTARA',
                'SIMALUNGUN, SUMATERA UTARA',
                'ASAHAN, SUMATERA UTARA',
                'LABUAN BATU, SUMATERA UTARA',
                'DAIRI, SUMATERA UTARA',
                'TOBA SAMOSIR, SUMATERA UTARA',
                'MANDAILING NATAL, SUMATERA UTARA',
                'NIAS SELATAN, SUMATERA UTARA',
                'PAKPAK BHARAT, SUMATERA UTARA',
                'HUMBANG HASUNDUTAN, SUMATERA UTARA',
                'SAMOSIR, SUMATERA UTARA',
                'SERDANG BEDAGAI, SUMATERA UTARA',
                'BATU BARA, SUMATERA UTARA',
                'MEDAN, SUMATERA UTARA',
                'PEMATANG SIANTAR, SUMATERA UTARA',
                'SIBOLGA, SUMATERA UTARA',
                'TANJUNG BALAI, SUMATERA UTARA',
                'BINJAI, SUMATERA UTARA',
                'TEBING TINGGI, SUMATERA UTARA',
                'PADANG SIDEMPUAN, SUMATERA UTARA',
                'PADANG LAWAS UTARA, SUMATERA UTARA',
                'PADANG LAWAS, SUMATERA UTARA',
                'PESISIR SELATAN, SUMATERA BARAT',
                'SOLOK, SUMATERA BARAT',
                'SAWAHLUNTOH-SIJUNJUNG, SUMATERA BARAT',
                'TANAH DATAR, SUMATERA BARAT',
                'PADANG PARIAMAN, SUMATERA BARAT',
                'AGAM, SUMATERA BARAT',
                'LIMA PULUH KOTO, SUMATERA BARAT',
                'PASAMAN, SUMATERA BARAT',
                'KEPULAUAN MENTAWAI, SUMATERA BARAT',
                'DHARMASRAYA, SUMATERA BARAT',
                'SOLOK SELATAN, SUMATERA BARAT',
                'PASAMAN BARAT, SUMATERA BARAT',
                'PADANG, SUMATERA BARAT',
                'SOLOK, SUMATERA BARAT',
                'SAWAH LUNTO, SUMATERA BARAT',
                'PADANG PANJANG, SUMATERA BARAT',
                'BUKIT TINGGI, SUMATERA BARAT',
                'PAYAKUMBUH, SUMATERA BARAT',
                'PARIAMAN, SUMATERA BARAT',
                'KAMPAR, RIAU',
                'INDRAGIRI HULU, RIAU',
                'BENGKALIS, RIAU',
                'INDRAGIRI HILIR, RIAU',
                'PELALAWAN, RIAU',
                'ROKAN HULU, RIAU',
                'ROKAN HILIR, RIAU',
                'SIAK, RIAU',
                'KUANTAN SINGINGI, RIAU',
                'PEKANBARU, RIAU',
                'DUMAI, RIAU',
                'KERINCI, JAMBI',
                'MERANGIN, JAMBI',
                'SAROLANGUN, JAMBI',
                'BATANG HARI, JAMBI',
                'MUARO JAMBI, JAMBI',
                'TANJUNG JABUNG BARAT, JAMBI',
                'TANJUNG JABUNG TIMUR, JAMBI',
                'BUNGO, JAMBI',
                'TEBO, JAMBI',
                'JAMBI, JAMBI',
                'OGAN KOMERING ULU, SUMATERA SELATAN',
                'OGAN KOMERING ILIR, SUMATERA SELATAN',
                'MUARA ENIM, SUMATERA SELATAN',
                'LAHAT, SUMATERA SELATAN',
                'MUSI RAWAS, SUMATERA SELATAN',
                'MUSI BANYUASIN, SUMATERA SELATAN',
                'BANYUASIN, SUMATERA SELATAN',
                'OGAN KOMERING ULU TIMUR, SUMATERA SELATAN',
                'OGAN KOMERING ULU SELATAN, SUMATERA SELATAN',
                'OGAN ILIR, SUMATERA SELATAN',
                'EMPAT LAWANG, SUMATERA SELATAN',
                'PALEMBANG, SUMATERA SELATAN',
                'PAGAR ALAM, SUMATERA SELATAN',
                'LUBUK LINGGAU, SUMATERA SELATAN',
                'PRABUMULIH, SUMATERA SELATAN',
                'BENGKULU SELATAN, BENGKULU',
                'REJANG LEBONG, BENGKULU',
                'BENGKULU UTARA, BENGKULU',
                'KAUR, BENGKULU',
                'SELUMA, BENGKULU',
                'MUKO-MUKO, BENGKULU',
                'LEBONG, BENGKULU',
                'KEPAHIANG, BENGKULU',
                'BENGKULU, BENGKULU',
                'LAMPUNG SELATAN, LAMPUNG',
                'LAMPUNG TENGAH, LAMPUNG',
                'LAMPUNG UTARA, LAMPUNG',
                'LAMPUNG BARAT, LAMPUNG',
                'TULANG BAWANG, LAMPUNG',
                'TANGGAMUS, LAMPUNG',
                'LAMPUNG TIMUR, LAMPUNG',
                'WAY KANAN, LAMPUNG',
                'BANDAR LAMPUNG, LAMPUNG',
                'METRO, LAMPUNG',
                'PESAWARAN, LAMPUNG',
                'BANGKA, KEPULAUAN BANGKA BELITUNG',
                'BELITUNG, KEPULAUAN BANGKA BELITUNG',
                'BANGKA SELATAN, KEPULAUAN BANGKA BELITUNG',
                'BANGKA TENGAH, KEPULAUAN BANGKA BELITUNG',
                'BANGKA BARAT, KEPULAUAN BANGKA BELITUNG',
                'BELITUNG TIMUR, KEPULAUAN BANGKA BELITUNG',
                'PANGKAL PINANG, KEPULAUAN BANGKA BELITUNG',
                'BINTAN, KEPULAUAN RIAU',
                'KARIMUN, KEPULAUAN RIAU',
                'NATUNA, KEPULAUAN RIAU',
                'LINGGA, KEPULAUAN RIAU',
                'BATAM, KEPULAUAN RIAU',
                'TANJUNG PINANG, KEPULAUAN RIAU',
                'KEPULAUAN SERIBU, DKI JAKARTA',
                'JAKARTA PUSAT, DKI JAKARTA',
                'JAKARTA UTARA, DKI JAKARTA',
                'JAKARTA BARAT, DKI JAKARTA',
                'JAKARTA SELATAN, DKI JAKARTA',
                'JAKARTA TIMUR, DKI JAKARTA',
                'BOGOR, JAWA BARAT',
                'SUKABUMI, JAWA BARAT',
                'CIANJUR, JAWA BARAT',
                'BANDUNG, JAWA BARAT',
                'GARUT, JAWA BARAT',
                'TASIKMALAYA, JAWA BARAT',
                'CIAMIS, JAWA BARAT',
                'KUNINGAN, JAWA BARAT',
                'CIREBON, JAWA BARAT',
                'MAJALENGKA, JAWA BARAT',
                'SUMEDANG, JAWA BARAT',
                'INDRAMAYU, JAWA BARAT',
                'SUBANG, JAWA BARAT',
                'PURWAKARTA, JAWA BARAT',
                'BEKASI, JAWA BARAT',
                'BANDUNG BARAT, JAWA BARAT',
                'BOGOR, JAWA BARAT',
                'SUKABUMI, JAWA BARAT',
                'BANDUNG, JAWA BARAT',
                'BEKASI, JAWA BARAT',
                'DEPOK, JAWA BARAT',
                'CIMAHI, JAWA BARAT',
                'BANJARMASIN, KALIMANTAN SELATAN',
                'PASER, KALIMANTAN TIMUR',
                'KUTAI KERTANEGARA, KALIMANTAN TIMUR',
                'BULUNGAN, KALIMANTAN TIMUR',
                'MALINAU, KALIMANTAN TIMUR',
                'KUTAI BARAT, KALIMANTAN TIMUR',
                'PENAJAM PASER UTAMA, KALIMANTAN TIMUR',
                'SAMARINDA, KALIMANTAN TIMUR',
                'BONTANG, KALIMANTAN TIMUR',
                'BOLAANG MONGONDO, SULAWESI UTARA',
                'MINAHASA, SULAWESI UTARA',
                'KEPULAUAN TALAUD, SULAWESI UTARA',
                'MINAHSA UTARA, SULAWESI UTARA',
                'BOLMONG UTARA, SULAWESI UTARA',
                'SITARO, SULAWESI UTARA',
                'BITUNG, SULAWESI UTARA',
                'MOBAGO, SULAWESI UTARA',
                'BANGGAI, SULAWESI TENGAH',
                'DONGGALA, SULAWESI TENGAH',
                'TOLI-TOLI, SULAWESI TENGAH',
                'MOROWALI, SULAWESI TENGAH',
                'BANGGAI KEPULAUAN, SULAWESI TENGAH',
                'TOJO UNA-UNA, SULAWESI TENGAH',
                'KEPULAUAN SELAYAR, SULAWESI SELATAN',
                'BULUKUMBA, SULAWESI SELATAN',
                'JENEPONTO, SULAWESI SELATAN',
                'TAKALAR, SULAWESI SELATAN',
                'SINJAI, SULAWESI SELATAN',
                'BONE, SULAWESI SELATAN',
                'PANGKAJENE KEPULAUAN, SULAWESI SELATAN',
                'SOPPENG, SULAWESI SELATAN',
                'WAJO, SULAWESI SELATAN',
                'SIDENRENG RAPANG, SULAWESI SELATAN',
                'ENREKANG, SULAWESI SELATAN',
                'TANA TORAJA, SULAWESI SELATAN',
                'LUWU TIMUR, SULAWESI SELATAN',
                'MAKASAR, SULAWESI SELATAN',
                'PALOPO, SULAWESI SELATAN',
                'KONAWE, SULAWESI TENGGARA',
                'MUNA, SULAWESI TENGGARA',
                'BUTON, SULAWESI TENGGARA',
                'BOMBANA, SULAWESI TENGGARA',
                'WAKATOBI, SULAWESI TENGGARA',
                'KONAWE UTARA, SULAWESI TENGGARA',
                'BUTON UTARA, SULAWESI TENGGARA',
                'BAU-BAU, SULAWESI TENGGARA',
                'BOALEMO, GORONTALO',
                'BONE BOLANGO, GORONTALO',
                'GORONTALO UTARA, GORONTALO',
                'MAMUJU UTARA, SULAWESI BARAT',
                'MAMUJU, SULAWESI BARAT',
                'POLEWALI MANDAR, SULAWESI BARAT',
                'MALUKU TENGAH, MALUKU',
                'MALUKU TENGGARA BARAT, MALUKU',
                'KEPULAUAN ARU, MALUKU',
                'SERAM BAGIAN TIMUR, MALUKU',
                'KAB. TUAL, MALUKU',
                'HALMAHERA BARAT, MALUKU UTARA',
                'HALMAHERA UTARA, MALUKU UTARA',
                'KEPULAUAN SULA, MALUKU UTARA',
                'TERNATE, MALUKU UTARA',
                'TIDORE, MALUKU UTARA',
                'JAYAWIJAYA, PAPUA',
                'NABIRE, PAPUA',
                'KEPULAUAN YAPEN, PAPUA',
                'SUMENEP, JAWA TIMUR',
                'PASURUAN, JAWA TIMUR',
                'BATU, JAWA TIMUR',
                'TULUNGAGUNG, JAWA TIMUR',
                'KEDIRI, JAWA TIMUR',
                'MALANG, JAWA TIMUR',
                'JEMBER, JAWA TIMUR',
                'BANYUWANGI, JAWA TIMUR',
                'SITUBONDO, JAWA TIMUR',
                'PROBOLINGGO, JAWA TIMUR',
                'SIDOARJO, JAWA TIMUR',
                'JOMBANG, JAWA TIMUR',
                'NGANJUK, JAWA TIMUR',
                'MADIUN, JAWA TIMUR',
                'NGAWI, JAWA TIMUR',
                'BOJONEGORO, JAWA TIMUR',
                'LAMONGAN, JAWA TIMUR',
                'GRESIK, JAWA TIMUR',
                'SAMPANG, JAWA TIMUR',
                'PAMEKASAN, JAWA TIMUR',
                'KEDIRI, JAWA TIMUR',
                'BLITAR, JAWA TIMUR',
                'PROBOLINGGO, JAWA TIMUR',
                'MOJOKERTO, JAWA TIMUR',
                'SURABAYA, JAWA TIMUR',
                'PANDEGLANG, BANTEN',
                'LEBAK, BANTEN',
                'SERANG, BANTEN',
                'TANGERANG, BANTEN',
                'SERANG, BANTEN',
                'BADUNG, BALI',
                'GIANYAR, BALI',
                'BANGLI, BALI',
                'KARANG ASEM, BALI',
                'DENPASAR, BALI',
                'LOMBOK TIMUR, NUSA TENGGARA BARAT',
                'DOMPU, NUSA TENGGARA BARAT',
                'SUMBAWA BARAT, NUSA TENGGARA BARAT',
                'MATARAM, NUSA TENGGARA BARAT',
                'KUPANG, NUSA TENGGARA TIMUR',
                'TIMOR TENGAH SELATAN, NUSA TENGGARA TIMUR',
                'ALOR, NUSA TENGGARA TIMUR',
                'ENDE, NUSA TENGGARA TIMUR',
                'NGADA, NUSA TENGGARA TIMUR',
                'MANGGARAI, NUSA TENGGARA TIMUR',
                'SUMBA BARAT, NUSA TENGGARA TIMUR',
                'LEMBATA, NUSA TENGGARA TIMUR',
                'MANGGARAI BARAT, NUSA TENGGARA TIMUR',
                'SUMBA BARAT DAYA, NUSA TENGGARA TIMUR',
                'MANGGARAI TIMUR, NUSA TENGGARA TIMUR',
                'PONTIANAK, KALIMANTAN BARAT',
                'KETAPANG, KALIMANTAN BARAT',
                'SINTANG, KALIMANTAN BARAT',
                'BENGKAYANG, KALIMANTAN BARAT',
                'MELAWI, KALIMANTAN BARAT',
                'KAYONG UTARA, KALIMANTAN BARAT',
                'SINGKAWANG, KALIMANTAN BARAT',
                'KOTAWARINGIN BARAT, KALIMANTAN TENGAH',
                'KAPUAS, KALIMANTAN TENGAH',
                'KATINGAN, KALIMANTAN TENGAH',
                'SUKAMARA, KALIMANTAN TENGAH',
                'LAMANDAU, KALIMANTAN TENGAH',
                'PULANG PISAU, KALIMANTAN TENGAH',
                'MURUNG RAYA, KALIMANTAN TENGAH',
                'PALANGKARAYA, KALIMANTAN TENGAH',
                'TANGERANG SELATAN, BANTEN',
                'BURU SELATAN, MALUKU',
                'PULAU MERANTI, RIAU',
                'LABUAN BATU UTARA, SUMATERA UTARA',
                'NIAS BARAT, SUMATERA UTARA',
                'GUNUNGSITOLI, SUMATERA UTARA',
                'BENGKULU TENGAH, BENGKULU',
                'MESUJI, LAMPUNG',
                'SABU RAIJUA, NUSA TENGGARA TIMUR',
                'TORAJA UTARA, SULAWESI SELATAN',
                'PULAU MOROTAI, MALUKU UTARA',
                'INTAN JAYA, PAPUA',
                'TOLIKARA, PAPUA',
                'WAROPEN, PAPUA',
                'MAPPI, PAPUA',
                'ASMAT, PAPUA',
                'JAYAPURA, PAPUA',
                'KABUPATEN YALIMO, PAPUA',
                'KABUPATEN LANNY JAYA, PAPUA',
                'KABUPATEN DOGIYAI, PAPUA',
                'MANOKWARI, PAPUA BARAT',
                'RAJA AMPAT, PAPUA BARAT',
                'TELUK BINTUNI, PAPUA BARAT',
                'KAIMANA, PAPUA BARAT',
                'SORONG, PAPUA BARAT',
                'BANJAR, KALIMANTAN SELATAN',
                'HULU SUNGAI SELATAN, KALIMANTAN SELATAN',
                'HULU SUNGAI UTARA, KALIMANTAN SELATAN',
                'TANAH BUMBU, KALIMANTAN SELATAN',
                'TASIKMALAYA, JAWA BARAT',
                'BANJAR, JAWA BARAT',
                'CILACAP, JAWA TENGAH',
                'PURBALINGGA, JAWA TENGAH',
                'BANJARNEGARA, JAWA TENGAH',
                'KEBUMEN, JAWA TENGAH',
                'PURWOREJO, JAWA TENGAH',
                'WONOSOBO, JAWA TENGAH',
                'MAGELANG, JAWA TENGAH',
                'KLATEN, JAWA TENGAH',
                'SUKOHARJO, JAWA TENGAH',
                'WONOGIRI, JAWA TENGAH',
                'KARANGANYAR, JAWA TENGAH',
                'SRAGEN, JAWA TENGAH',
                'BLORA, JAWA TENGAH',
                'REMBANG, JAWA TENGAH',
                'PATI, JAWA TENGAH',
                'KUDUS, JAWA TENGAH',
                'JEPARA, JAWA TENGAH',
                'DEMAK, JAWA TENGAH',
                'SEMARANG, JAWA TENGAH',
                'TEMANGGUNG, JAWA TENGAH',
                'KENDAL, JAWA TENGAH',
                'BATANG, JAWA TENGAH',
                'PEKALONGAN, JAWA TENGAH',
                'PEMALANG, JAWA TENGAH',
                'TEGAL, JAWA TENGAH',
                'BREBES, JAWA TENGAH',
                'MAGELANG, JAWA TENGAH',
                'SURAKARTA, JAWA TENGAH',
                'SALATIGA, JAWA TENGAH',
                'SEMARANG, JAWA TENGAH',
                'PEKALONGAN, JAWA TENGAH',
                'TEGAL, JAWA TENGAH',
                'KULONPROGO, DAERAH ISTIMEWA YOGYAKARTA',
                'BANTUL, DAERAH ISTIMEWA YOGYAKARTA',
                'GUNUNG KIDUL, DAERAH ISTIMEWA YOGYAKARTA',
                'SLEMAN, DAERAH ISTIMEWA YOGYAKARTA',
                'YOGYAKARTA, DAERAH ISTIMEWA YOGYAKARTA',
                'PACITAN, JAWA TIMUR',
                'PONOROGO, JAWA TIMUR',
                'TRENGGALEK, JAWA TIMUR',
                'BLITAR, JAWA TIMUR',
                'LUMAJANG, JAWA TIMUR',
                'BONDOWOSO, JAWA TIMUR',
                'PASURUAN, JAWA TIMUR',
                'MOJOKERTO, JAWA TIMUR',
                'MAGETAN, JAWA TIMUR',
                'TUBAN, JAWA TIMUR',
                'BANGKALAN, JAWA TIMUR',
                'MALANG, JAWA TIMUR',
                'MADIUN, JAWA TIMUR',
                'TANGERANG, BANTEN',
                'CILEGON, BANTEN',
                'JEMBRANA, BALI',
                'KLUNGKUNG, BALI',
                'BULELENG, BALI',
                'LOMBOK BARAT, NUSA TENGGARA BARAT',
                'SUMBAWA, NUSA TENGGARA BARAT',
                'BIMA, NUSA TENGGARA BARAT',
                'BIMA, NUSA TENGGARA BARAT',
                'TIMOR TENGAH UTARA, NUSA TENGGARA TIMUR',
                'BELU, NUSA TENGGARA TIMUR',
                'SIKA, NUSA TENGGARA TIMUR',
                'SUMBA TIMUR, NUSA TENGGARA TIMUR',
                'ROTENDAO, NUSA TENGGARA TIMUR',
                'NAGEKO, NUSA TENGGARA TIMUR',
                'KUPANG, NUSA TENGGARA TIMUR',
                'SAMBAS, KALIMANTAN BARAT',
                'SANGGAU, KALIMANTAN BARAT',
                'KAPUAS HULU, KALIMANTAN BARAT',
                'SEKADAU, KALIMANTAN BARAT',
                'PONTIANAK, KALIMANTAN BARAT',
                'KUBU RAYA, KALIMANTAN BARAT',
                'WARINGIN TIMUR, KALIMANTAN TENGAH',
                'BARITO UTARA, KALIMANTAN TENGAH',
                'SERUYAN, KALIMANTAN TENGAH',
                'GUNUNG MAS, KALIMANTAN TENGAH',
                'BARITO TIMUR, KALIMANTAN TENGAH',
                'TANAH LAUT, KALIMANTAN SELATAN',
                'MANGGARAI TIMUR, NUSA TENGGARA TIMUR',
                'MALUKU BARAT DAYA, MALUKU',
                'LOMBOK UTARA, NUSA TENGGARA BARAT',
                'LABUAN BATU SELATAN, SUMATERA UTARA',
                'NIAS UTARA, SUMATERA UTARA',
                'KEPULAUAN ANAMBAS, KEPULAUAN RIAU',
                'PRINGSEWU, LAMPUNG',
                'TULANG BAWANG BARAT, LAMPUNG',
                'BOLAANG MONGONDO SELATAN, SULAWESI UTARA',
                'SIGI, SULAWESI TENGAH',
                'TAMBRAUW, PAPUA BARAT',
                'DEIYAI, PAPUA',
                'BOVEN DIGUL, PAPUA',
                'MAMBERAMO RAYA, PAPUA',
                'KABUPATEN MABERAMO TENGAH, PAPUA',
                'KABUPATEN DUGA, PAPUA',
                'KABUPATEN PUNCAK, PAPUA',
                'SORONG, PAPUA BARAT',
                'SORONG SELATAN, PAPUA BARAT',
                'TELUK WONDAMA, PAPUA BARAT',
                'BARU, KALIMANTAN SELATAN',
                'TAPIN, KALIMANTAN SELATAN',
                'HULU SUNGAI TENGAH, KALIMANTAN SELATAN',
                'TABALONG, KALIMANTAN SELATAN',
                'BALANGAN, KALIMANTAN SELATAN',
                'BANJAR BARU, KALIMANTAN SELATAN',
                'BERAU, KALIMANTAN TIMUR',
                'NUNUKAN, KALIMANTAN TIMUR',
                'KUTAI TIMUR, KALIMANTAN TIMUR',
                'BALIKPAPAN, KALIMANTAN TIMUR',
                'TARAKAN, KALIMANTAN TIMUR',
                'TANAH TIDUNG, KALIMANTAN TIMUR',
                'KEPULAUAN SANGIHE, SULAWESI UTARA',
                'MINAHASA SELATAN, SULAWESI UTARA',
                'MINAHASA TENGGARA, SULAWESI UTARA',
                'MANADO, SULAWESI UTARA',
                'TOMOHON, SULAWESI UTARA',
                'POSO, SULAWESI TENGAH',
                'BUOL, SULAWESI TENGAH',
                'PARIMO, SULAWESI TENGAH',
                'PALU, SULAWESI TENGAH',
                'BANTAENG, SULAWESI SELATAN',
                'GOWA, SULAWESI SELATAN',
                'MAROS, SULAWESI SELATAN',
                'BARRU, SULAWESI SELATAN',
                'PINRANG, SULAWESI SELATAN',
                'LUWU, SULAWESI SELATAN',
                'LUWU UTARA, SULAWESI SELATAN',
                'PARE-PARE, SULAWESI SELATAN',
                'KOLAKA, SULAWESI TENGGARA',
                'KONAWE SELATAN, SULAWESI TENGGARA',
                'KOLAKA UTARA, SULAWESI TENGGARA',
                'KENDARI, SULAWESI TENGGARA',
                'GORONTALO, GORONTALO',
                'POHUWATO, GORONTALO',
                'GORONTALO, GORONTALO',
                'MAMASA, SULAWESI BARAT',
                'MAJENE, SULAWESI BARAT',
                'MALUKU TENGGARA, MALUKU',
                'BURU, MALUKU',
                'SERAM BAGIAN BARAT, MALUKU',
                'AMBON, MALUKU',
                'HALMAHERA TENGAH, MALUKU UTARA',
                'HALMAHERA SELATAN, MALUKU UTARA',
                'HALMAHERA TIMUR, MALUKU UTARA',
                'MERAUKE, PAPUA',
                'JAYAPURA, PAPUA',
                'BIAK NUMFOR, PAPUA',
                'KARAWANG, JAWA BARAT',
                'CIREBON, JAWA BARAT',
                'TABANAN, BALI',
                'LOMBOK TENGAH, NUSA TENGGARA BARAT',
                'FLORES TIMUR, NUSA TENGGARA TIMUR',
                'SUMBA TENGAH, NUSA TENGGARA TIMUR',
                'LANDAK, KALIMANTAN BARAT',
                'BARITO SELATAN, KALIMANTAN TENGAH',
                'SUNGAI PENUH, JAMBI',
                'BOLAANG MONGONDO TIMUR, SULAWESI UTARA',
                'SUPIORI, PAPUA',
                'FAKFAK, PAPUA BARAT',
                'BARITO KUALA, KALIMANTAN SELATAN',
                'BANYUMAS, JAWA TENGAH',
                'BOYOLALI, JAWA TENGAH',
                'GROBOGAN, JAWA TENGAH',
                'MUSI RAWAS UTARA, SUMATERA SELATAN',
                'BULUNGAN, KALIMANTAN UTARA',
                'MALINAU, KALIMANTAN UTARA',
                'NUNUKAN, KALIMANTAN UTARA',
                'TANA TIDUNG, KALIMANTAN UTARA',
                'TARAKAN, KALIMANTAN UTARA',
                'MALAKA, NUSA TENGGARA TIMUR',
                'KOLAKA TIMUR, SULAWESI TENGGARA'
            ]
        ]);
    }

    public function store(Request $request)
    {
        $toko = Toko::create([
            'perusahaan_id' => $request->perusahaan,
            'negara' => $request->negara,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'alamat' => $request->alamat,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'catatan' => $request->catatan
        ]);

        if ($request->has('foto')){
            foreach ($request->foto as $file){
                $foto = Foto::create([
                    'toko_id' => $toko->id,
                    'dir' => ''
                ]);
                $file->move('images/galeri', $foto->id.'_'.$foto->id.'_'.$file->getClientOriginalName());
                $foto->dir = 'images/galeri/'.$foto->id.'_'.$foto->id.'_'.$file->getClientOriginalName();
                $foto->save();
            }
        }

        return back();
    }

    public function storeMany(Request $request)
    {
        $perusahaan = Perusahaan::find($request->perusahaan);

        $query = $perusahaan->nama.' '.$request->lokasi;

        $tokos = OpenStreetMaps::geocode($query, 50);

        foreach ($tokos as $toko){
            $geocode = OpenStreetMaps::reverseGeocode($toko->lat, $toko->lon, 15);

            $t = Toko::create([
                'perusahaan_id' => $perusahaan->id,
                'negara' => $geocode->address->country ?? '',
                'provinsi' => $geocode->address->state ?? '',
                'kota' => $geocode->address->city ?? '',
                'kecamatan' => $geocode->address->county ?? '',
                'alamat' => $toko->display_name,
                'lat' => $toko->lat,
                'lng' => $toko->lon
            ]);
        }

        return back();
    }

    public function geocode(Request $request)
    {
        return json_encode(OpenStreetMaps::geocode($request->alamat));
    }

    public function reverse(Request $request)
    {
        return json_encode(OpenStreetMaps::reverseGeocode($request->lat, $request->lng));
    }

    public function update(Request $request)
    {
        Toko::find($request->id)->update([
            'perusahaan_id' => $request->perusahaan_id,
            'negara' => $request->negara,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'alamat' => $request->alamat,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'catatan' => $request->catatan
        ]);

        return back();
    }

    public function delete(Request $request)
    {
        Toko::find(decrypt($request->id))->delete();

        return back();
    }

    public function foto(Request $request)
    {
        return view('toko_foto', [
            'toko' => Toko::query()->find(decrypt($request->id)),
            'no' => $request->no
        ]);
    }

    public function fotoStore(Request $request)
    {
        if ($request->has('dir')){
            foreach ($request->dir as $file){
                $foto = Foto::create([
                    'toko_id' => $request->toko_id,
                    'dir' => ''
                ]);
                $file->move('images/galeri', $foto->id.'_'.$foto->id.'_'.$file->getClientOriginalName());
                $foto->dir = 'images/galeri/'.$foto->id.'_'.$foto->id.'_'.$file->getClientOriginalName();
                $foto->save();
            }
        }

        return back();
    }

    public function fotoDelete(Request $request)
    {
        Foto::query()->find(decrypt($request->id))->delete();

        return back();
    }
}
