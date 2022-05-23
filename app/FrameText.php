<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrameText extends Model
{
	protected $table = 'frame_texts';

    static $fontList = [
        'bn_galada_regular.ttf',
        'bn_hindsiliguri_regular.ttf',
        'bn_hindssliguri_bold.ttf',
        'bn_notosansbengali_variable_font_wdth_wght.ttf',
        'breeserif_regular.otf',
        'en_akronim_regular.ttf',
        'en_aladin_regular.ttf',
        'en_alfaslabone_regular.ttf',
        'en_cookie_regular.ttf',
        'en_emilyscandy_regular.ttf',
        'en_fasterone_regular.ttf',
        'en_fredoka_variablefont_wdth.ttf',
        'en_fugazone_regular.ttf',
        'en_hurricane_regular.ttf',
        'en_lobster_regular.ttf',
        'en_meaculpa_regular.ttf',
        'en_notoserif_bold.ttf',
        'en_notoserif_regular.ttf',
        'en_pacifico_regular.ttf',
        'en_roboto_bold.ttf',
        'en_roboto_regular.ttf',
        'en_rye_regular.ttf',
        'en_satisfy_regular.ttf',
        'guj_hindvadodara_bold.ttf',
        'guj_hindvadodara_medium.ttf',
        'guj_kumarone_regular.ttf',
        'guj_muktavaani_extrabold.ttf',
        'guj_muktavaani_regular.ttf',
        'guj_notosansgujarati_extrabold.ttf',
        'guj_notosansgujarati_regular.ttf',
        'guj_shrikhand_regular.ttf',
        'hi_amita_bold.ttf',
        'hi_amita_regular.ttf',
        'hi_arya_bold.ttf',
        'hi_arya_regular.ttf',
        'hi_gotu_regular.ttf',
        'hi_hind_bold.ttf',
        'hi_hind_regular.ttf',
        'hi_kalam_bold.ttf',
        'hi_kalam_regular.ttf',
        'hi_khand_bold.ttf',
        'hi_khand_medium.ttf',
        'hi_khand_regular.ttf',
        'hi_laila_bold.ttf',
        'hi_laila_regular.ttf',
        'hi_martel_black.ttf',
        'hi_martel_bold.ttf',
        'hi_martel_extrabold.ttf',
        'hi_martel_extralight.ttf',
        'hi_martel_light.ttf',
        'hi_martel_regular.ttf',
        'hi_martel_semibold.ttf',
        'hi_mukta_bold.ttf',
        'hi_mukta_regular.ttf',
        'hi_mukta_semibold.ttf',
        'hi_poppins_extrabold.ttf',
        'hi_poppins_medium.ttf',
        'hi_poppins_regular.ttf',
        'hi_yatraone_regular.ttf',
        'kn_akayakanadaka_regular.ttf',
        'kn_notoserifkannada_variablefont.ttf',
        'tl_hindguntur_bold.ttf',
        'tl_hindguntur_regular.ttf',
        'tl_ramaraja_regular.ttf',
        'tm_hindmadurai_bold.ttf',
        'tm_hindmadurai_regular.ttf',
        'tm_meerainimai_regular.ttf',
    ];

    static $textAligns = [
        'L',
        'C',
        'R',
    ];

    public function frame()
    {
        return $this->belongsTo('App\Frame');
    }

    public function field()
    {
        return $this->belongsTo('App\BusinessField', 'text_for');
    }
}
