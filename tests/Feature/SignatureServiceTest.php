<?php

namespace Jooyeshgar\Moadian\Tests\Feature;

use Jooyeshgar\Moadian\Services\SignatureService;
use Jooyeshgar\Moadian\Tests\TestCase;

class SignatureServiceTest extends TestCase
{
    public function testNormalizer(): void
    {
        $headers = '{"header": {"taxid": "A111220E1B9155CB1F18C7","indatim": "1665490063785","Indati2m": "1665490063785","inty": "1","inno": "0000011300","irtaxid": null,"inp": "1","ins": "1","tins": "19117484910001","tob": "1","bid": "0","tinb": "19117484910002","sbc": "0","bpc": "0","bbc": "0","ft": "0","bpn": "0","scln": "0","scc": "0","crn": "0","billid": "0","tprdis": "2400000","tdis": "0","tadis": "2400000","tvam": "216000","todam": "0","tbill": "2616000","setm": "1","cap": "2616000","insp": "0","tvop": "216000","tax17": "0"}}';
        $body    = '{"body": [{"sstid": "1254219865985","sstt": "روغن بهران","am": "1","mu": "لیتر","fee": "2400000","cfee": "0","cut": "0","exr": "0","prdis": "2400000","dis": "0","adis": "2400000","vra": "0.09","vam": "216000","odt": "0","odr": "0","odam": "0","olt": "0","olr": "0","olam": "0","consfee": "0","spro": "0","bros": "0","tcpbs": "0","cop": "0","vop": "216000","bsrn": null,"tsstam": "2616000"}],"payments": [{"iinn": "125036","acn": "252544","trmn": "2356566","trn": "252545","pcn": "6037991785693265","pid": "19117484910002","pdt": "1665490061447"}],"extension": [{"key": null,"value": null}]}';
        $normalizedString = SignatureService::normalizer(json_decode($headers, true), json_decode($body, true));
        
        $expected = '2400000#1#0###0#0#0#0#0#0#2400000#لیتر#0#0#0#0#0#0#2400000#0#1254219865985#روغن بهران#0#2616000#216000#216000#0.09#####1665490063785#0#0#0#0#0#2616000#0#0#1665490063785#0000011300#1#1#0#1###0#0#0#1#2400000#0#A111220E1B9155CB1F18C7#2616000#0#19117484910002#19117484910001#1#0#2400000#216000#216000#252544#125036#6037991785693265#1665490061447#19117484910002#2356566#252545';

        $this->assertSame($expected, $normalizedString);
    }
}