<?php
/**
 * Copyright 2016 University of Liverpool
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace pgb_liv\php_ms\Test\Unit;

use pgb_liv\php_ms\Search\MascotSearch;
use pgb_liv\php_ms\Search\Parameters\MascotSearchParameters;

class MascotSearchTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearch::__construct
     *
     * @uses pgb_liv\php_ms\Search\MascotSearch
     */
    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $search = new MascotSearch(MASCOT_HOST, MASCOT_PORT, MASCOT_PATH);
        $this->assertInstanceOf('\pgb_liv\php_ms\Search\MascotSearch', $search);
        
        return $search;
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearch::__construct
     * @covers pgb_liv\php_ms\Search\MascotSearch::authenticate
     * @covers pgb_liv\php_ms\Search\MascotSearch::getCookieHeader
     * @covers pgb_liv\php_ms\Search\MascotSearch::sendPost
     * @covers pgb_liv\php_ms\Search\MascotSearch::readResponse
     *
     * @uses pgb_liv\php_ms\Search\MascotSearch
     */
    public function testCanGetValidAuthentication()
    {
        $search = new MascotSearch(MASCOT_HOST, MASCOT_PORT, MASCOT_PATH);
        $isAuthed = $search->authenticate(MASCOT_USER, MASCOT_PASS);
        
        $this->assertTrue($isAuthed);
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearch::__construct
     * @covers pgb_liv\php_ms\Search\MascotSearch::authenticate
     * @covers pgb_liv\php_ms\Search\MascotSearch::getCookieHeader
     * @covers pgb_liv\php_ms\Search\MascotSearch::sendPost
     * @covers pgb_liv\php_ms\Search\MascotSearch::readResponse
     *
     * @uses pgb_liv\php_ms\Search\MascotSearch
     */
    public function testCanGetInvalidAuthentication()
    {
        $search = new MascotSearch(MASCOT_HOST, MASCOT_PORT, MASCOT_PATH);
        $isAuthed = $search->authenticate('fakeuser', 'fakepass');
        
        $this->assertFalse($isAuthed);
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearch::__construct
     * @covers pgb_liv\php_ms\Search\MascotSearch::authenticate
     * @covers pgb_liv\php_ms\Search\MascotSearch::getSearches
     * @covers pgb_liv\php_ms\Search\MascotSearch::getCookieHeader
     * @covers pgb_liv\php_ms\Search\MascotSearch::sendGet
     * @covers pgb_liv\php_ms\Search\MascotSearch::readResponse
     *
     * @uses pgb_liv\php_ms\Search\MascotSearch
     */
    public function testCanGetValidRecentSearches()
    {
        $searchLimit = 15;
        
        $search = new MascotSearch(MASCOT_HOST, MASCOT_PORT, MASCOT_PATH);
        $isAuthed = $search->authenticate(MASCOT_USER, MASCOT_PASS);
        $lastSearches = $search->getSearches($searchLimit);
        
        $this->assertEquals($searchLimit, count($lastSearches));
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearch::__construct
     * @covers pgb_liv\php_ms\Search\MascotSearch::authenticate
     * @covers pgb_liv\php_ms\Search\MascotSearch::getSearches
     * @covers pgb_liv\php_ms\Search\MascotSearch::getXml
     * @covers pgb_liv\php_ms\Search\MascotSearch::getCookieHeader
     * @covers pgb_liv\php_ms\Search\MascotSearch::sendPost
     * @covers pgb_liv\php_ms\Search\MascotSearch::readResponse
     *
     * @uses pgb_liv\php_ms\Search\MascotSearch
     */
    public function testCanGetValidRecentSearchData()
    {
        // Attempts to get smallest result of last 50 to improve test speed
        $searchLimit = 50;
        $search = new MascotSearch(MASCOT_HOST, MASCOT_PORT, MASCOT_PATH);
        $isAuthed = $search->authenticate(MASCOT_USER, MASCOT_PASS);
        $lastSearches = $search->getSearches($searchLimit);
        
        $duration = 100000;
        $filePath = '';
        foreach ($lastSearches as $record) {
            if ($record['status'] == 'User read res' && ($filePath == '' || $record['dur'] < $duration)) {
                $filePath = $record['filename'];
                $duration = $record['dur'];
            }
        }
        
        if ($filePath == '') {
            return;
        }
        
        $result = $search->getXml($filePath);
        
        preg_match('/F[0-9]+/', $filePath, $matches);
        
        $this->assertEquals($matches[0] . '.xml', $result['name']);
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearch::__construct
     * @covers pgb_liv\php_ms\Search\MascotSearch::authenticate
     * @covers pgb_liv\php_ms\Search\MascotSearch::search
     * @covers pgb_liv\php_ms\Search\MascotSearch::getXml
     * @covers pgb_liv\php_ms\Search\MascotSearch::getCookieHeader
     * @covers pgb_liv\php_ms\Search\MascotSearch::sendPost
     * @covers pgb_liv\php_ms\Search\MascotSearch::readResponse
     *
     * @uses pgb_liv\php_ms\Search\MascotSearch
     * @uses pgb_liv\php_ms\Search\MascotSearchParameters
     */
    public function testCanSubmitValidJob()
    {
        $filePath = $this->createMgf();
        
        $search = new MascotSearch(MASCOT_HOST, MASCOT_PORT, MASCOT_PATH);
        $isAuthed = $search->authenticate(MASCOT_USER, MASCOT_PASS);
        
        $params = new MascotSearchParameters();
        $params->setUserName('php-ms Unit Test');
        $params->setUserMail('example@example.com');
        $params->setTitle('php-ms Unit Test');
        $params->setDatabases('Mouse_AndrewC_NOV16');
        $params->setFixedModifications('Carbamidomethyl (C)');
        $params->setVariableModifications('Phospho (ST)');
        $params->setPrecursorTolerance(5);
        $params->setPrecursorToleranceUnit(MascotSearchParameters::UNIT_PPM);
        $params->setFragmentTolerance(0.01);
        $params->setSpectraPath($filePath);
        
        $datPath = $search->search($params);
        $result = $search->getXml($datPath);
        
        preg_match('/F[0-9]+/', $datPath, $matches);
        $this->assertEquals($matches[0] . '.xml', $result['name']);
    }

    public function createMgf()
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'php-ms');
        file_put_contents($tempFile, 
            'SEARCH=MIS
MASS=Monoisotopic
BEGIN IONS
TITLE=260416_Sample5.4879.4879.3 (intensity=1303211688.9366)
PEPMASS=649.26976291739
CHARGE=3+
SCANS=4879
RTINSECONDS=1159.04
102.05553 12677.62
129.10262 38333.64
147.11298 14107.91
187.10803 29838.09
215.13945 50076.41
242.07761 12377.44
243.13416 24044.47
275.20828 24292.32
696.30029 26707.27
696.8031 12211.04
745.83691 11550.99
746.33594 11275.97
803.84851 10917.92
END IONS
BEGIN IONS
TITLE=260416_Sample5.4991.4991.3 (intensity=1303211688.9366)
PEPMASS=649.26976291739
CHARGE=3+
SCANS=4991
RTINSECONDS=1159.04
101.10793 1545245.88
102.05554 16381835
107.81943 739175.31
120.10506 654014.19
127.08662 1622907.38
129.10252 45388320
130.05022 900278.5
130.08658 14429007
130.10588 1331470.75
142.08652 4309907
145.06114 844343.13
147.11304 15109376
148.11644 1005450.81
157.06082 842783.5
157.09734 1084825
166.62308 686765.63
169.0972 2904649.75
170.09286 5419757
170.11725 1032045.44
181.06081 3586501.5
185.05606 1648340.75
186.12383 5366432.5
187.10806 38449564
188.11143 3840602.75
197.12883 2698668.25
199.07104 1723599.75
215.10321 8818845
215.13936 58913452
216.14308 6057171.5
217.08202 4287409.5
226.11874 7844021.5
227.06659 9415765
227.12175 1206699.38
231.09831 900883.88
240.17033 785528.69
241.08174 1050679.25
242.07738 15373686
243.13425 33279686
244.12923 3888248.25
244.13986 865729.19
245.0771 16196404
257.19711 3975704.5
258.18164 992107.38
258.20044 930257.5
262.58621 712382.94
272.12372 725544.25
273.15521 659664.13
275.20813 31044738
276.21124 2843059.75
280.12906 1262271.38
298.13962 4598306
314.08817 253071.8
314.09821 3828403.5
315.10156 755454.63
326.13443 2679899.25
341.14569 4166430.5
343.12332 1216779.13
353.10974 3264267.25
358.16138 27240054
359.16409 4411227
370.17404 744423.38
371.12082 9839692
372.1232 933440.5
372.22372 3951385.25
383.15698 1087908.75
388.18182 5895265.5
388.1969 178399.55
390.23553 6508489.5
429.24347 2461748.75
456.17249 1371984.38
457.2316 874286.06
470.18747 1120898.25
482.15225 1312733.63
485.19827 1330517.63
500.16263 3749457.5
503.20981 2924878.75
516.27716 3692815.25
517.27869 691989.19
518.33075 1495615.5
557.75397 858045.69
566.76093 2299283.25
567.20343 3039677
567.2627 807573.13
575.35101 6015615.5
575.76624 1694885
576.26581 2747684.25
585.21429 3449073.75
597.17987 1607358.75
601.17499 1099876.75
615.18787 1300902.63
618.23523 904614.06
623.74658 1245113.88
624.27142 764970.44
631.30652 835574.94
632.25299 2567336.75
644.37366 1561626.25
658.78369 1178225.38
659.27991 2804177
659.78058 1335390.13
662.38403 13239769
663.38647 4319047.5
667.78931 6845499
668.29065 4630676.5
668.79346 1408995
672.78009 4118373.75
673.28253 1293904.5
673.78265 1084481.75
678.28937 2800493
678.76123 431716.38
678.78583 3004111.5
679.2879 1322860.88
681.79645 932454.56
687.29486 7171236
687.79431 6651311.5
688.2951 3137465.75
696.29999 31400670
696.802 23909932
697.30225 8073377
712.20569 1294863.75
724.80817 933084.38
728.32275 1388527.25
729.26648 1626589.75
730.21588 3997424.75
736.82892 4155215.25
745.8349 8997816
746.33417 11265762
746.83466 1301260.75
747.28088 1432370.38
750.82776 1015114.94
751.32416 1280651.88
777.40997 8945510
778.41406 4756776.5
791.10327 785680.63
794.34369 1075395.25
794.83185 3812942.75
795.32788 3063970.25
799.23975 781850.75
803.34808 10178383
803.80341 217257.81
803.85046 8278363
804.35187 1212499.13
804.84973 1002873.13
849.85553 989543.56
850.85791 850809.31
858.86292 10267567
859.36267 4037933.5
859.86664 2952139.25
867.86987 4055368.75
868.36646 4714767.5
868.86981 1475264.63
874.42548 1406672.75
892.43988 8454036
893.43762 3774269.25
894.43549 798984.5
986.39893 1004856.88
987.39594 866491.25
1002.36682 879354.19
1003.46777 3099072
1021.47833 6254017
1022.48279 1984221.5
1060.36646 1362727
1100.37903 1153275.75
1117.39392 7214805
1118.39148 1377083.38
1132.51257 3326999.25
1133.50464 1155434.5
1150.52002 4170386.75
1151.52161 3882683.5
1217.46375 1271886.25
1245.4801 3902911
1246.48999 1415049.25
1248.54529 1010857
1265.54517 1565002.25
1317.53064 1004293.19
1331.48999 1722554.88
1332.48779 1243366.38
1373.57959 2912199.75
1374.57092 1447955.25
1391.59375 9536181
1392.59692 6311221.5
1393.59375 1639843.13
1740.88782 859227.88
END IONS
BEGIN IONS
TITLE=260416_Sample5.5101.5101.3 (intensity=1303211688.9366)
PEPMASS=649.26976291739
CHARGE=3+
SCANS=5101
RTINSECONDS=1159.04
101.10791 50947.59
102.05555 345895.06
121.76055 15004.4
127.08671 26684.43
129.10262 830119.19
130.08661 228188.5
130.10576 61829.07
139.08664 16928.16
141.05408 13412.07
142.08644 61976.38
145.06107 21468.88
147.11305 419551.13
155.08188 31593.06
157.06065 14704.54
157.09752 21441.98
157.76019 12935.61
163.39232 14346.09
169.09726 25040.03
170.08134 22230.14
170.09276 118911.1
170.11751 25633.73
181.06128 28665.7
181.09651 12698.76
185.05591 30054.27
186.12405 117677.82
187.10802 834099.19
188.11122 76195.58
197.12851 78011.77
199.07127 73063.11
205.76131 14249.35
215.10324 196293.02
215.13948 1408535
215.15062 27889.99
216.14285 160115.94
217.08192 25520.99
226.11888 115224.86
227.06665 130912.97
241.08182 18115.44
242.07767 290775.47
243.1342 691673.69
244.12944 79571.83
244.13844 24895.63
245.07726 350866.22
246.08011 20573.94
257.19742 114647.69
258.18088 13864.47
259.09271 17731.82
272.12415 67671.71
272.93152 13870.11
273.15588 14492.07
275.2084 683493.63
276.21124 71706.7
298.14014 80420.15
314.09827 75210.13
322.68881 15353.38
325.1149 14057.15
326.13513 22212.27
331.69641 23440.2
340.15109 14946.58
341.14594 77298.92
343.1254 23052.7
344.14551 28051.94
353.10886 74674.1
358.16125 550748.44
359.16553 102920.77
370.17285 19382.92
371.12082 175140.52
372.22382 68553.86
388.1828 135628.06
389.18588 18151.82
389.20776 48920.12
390.23523 173295.44
391.23834 19416.42
429.23752 56365.05
441.25226 38850.13
452.17807 16052.04
456.17361 26738.7
464.53357 17653.39
468.14063 15922.87
470.18781 18983.8
471.13446 12485.93
482.15244 19550.94
485.20013 22550.95
486.14734 24059.06
500.16171 110050.89
501.16537 21941.04
503.21008 77825.56
511.24533 27658.95
511.73981 14644.27
516.27716 79495.01
518.32965 59270.14
534.28931 29099.21
549.19312 18517.11
566.76025 72726.61
567.20361 77093.96
567.26526 14865.04
574.43188 16218.67
575.35126 142050.66
575.76477 68096.91
576.2677 24375.91
576.35492 15813.87
585.21643 57494.42
597.17737 26571.76
600.22668 28499.54
614.24274 23191.19
615.19336 91261.99
616.19275 15417.31
618.23743 27541.94
631.30603 17498.92
632.25427 18016.25
633.27667 61658.93
644.37146 26453.68
645.37646 14841.71
650.27325 18384.66
658.78278 29533.37
659.27856 59690.8
659.78192 17921.59
662.38397 358498.19
663.38898 135265.05
663.77808 23226.97
667.79034 166546.2
668.28827 72287.57
669.28815 26773.93
673.28088 28607.5
678.28937 16853.62
678.78156 15978.81
687.2948 224787.98
687.79498 199148.19
688.29572 58566.36
696.30017 753019.31
696.80249 560988.88
697.30225 247246.91
698.29944 20969.65
712.20251 29050.03
714.25909 32539.31
729.26617 25196.64
730.21545 73149.15
736.82886 72294.95
737.33051 83515.41
745.83466 346095.72
746.33588 189047.45
746.83612 63490.9
747.27496 20049.31
759.40045 24749.47
777.41113 209276.72
778.40955 61173.29
785.33606 28090.23
785.82983 21701.96
794.33966 81612.88
794.83398 79694.1
795.33783 28076.96
799.23615 17914.65
803.34717 227657.69
803.85022 229767.34
804.3501 139209.03
804.84595 22681.44
827.34601 24649.04
829.28485 29731.74
849.85657 80256.17
850.36188 31583.48
850.85968 20579.98
852.83838 15026.93
858.30829 52420.29
858.86652 176725.56
859.37 155385.42
859.86517 91462.13
867.86774 84723.23
868.37311 115885.57
868.87372 16025.35
874.42444 64279.59
876.32104 26404.05
892.43774 205195.64
893.4408 95051.16
985.45648 18056.86
1003.46954 73400.39
1004.48199 16588.38
1021.47974 211093.56
1022.47675 85338.88
1023.47925 20382.75
1053.29626 18622.08
1099.38013 27264.63
1117.39404 181972.47
1118.39197 85687.47
1132.51025 77923.05
1150.52637 98372.55
1151.52405 52831.74
1188.46619 16265.83
1245.48706 75351.1
1246.49048 26898.13
1247.49866 16068.01
1263.48401 28278.76
1264.50024 22073.48
1265.53906 24123.51
1317.55005 18719.63
1331.48474 25603.26
1332.49756 23921.44
1373.58765 53368.63
1374.58044 22166.16
1391.59412 174365.2
1392.59717 145745.31
1393.59558 46906.93
1443.51575 24773.35
1467.16687 16170.3
1996.45056 14359.98
END IONS
BEGIN IONS
TITLE=260416_Sample5.5217.5217.3 (intensity=1303211688.9366)
PEPMASS=649.26976291739
CHARGE=3+
SCANS=5217
RTINSECONDS=1159.04
102.05557 448912.38
127.08703 20015.61
129.10258 945586
130.05019 37983.61
130.08658 150393.16
130.10594 45734.16
139.08655 22167.28
147.11305 212331.16
155.08171 24650.88
169.09695 17939.47
170.09253 33359.75
170.1176 20755.48
173.09239 49170.77
185.05588 37399.99
186.12387 25606.97
187.10803 195992.13
188.1116 19207.63
195.11322 46091.75
197.12894 46218.38
199.07155 27711.61
201.08727 63394.72
215.10324 46502.93
215.13945 351118.03
216.1429 37496.6
217.08224 35555.69
222.12415 55797.41
223.10805 27591.72
225.1232 11942.45
226.11864 34250.44
227.06647 41029.64
240.13452 295660.25
241.08203 43107.41
241.13771 40220.55
242.07727 55821.94
243.13437 182402.5
244.12927 27036.58
245.07712 117841.98
246.08051 11858.34
257.19739 30839.64
258.1449 61084.66
258.18088 8607
259.09302 32787.07
275.20831 124865.13
276.15549 11707.99
282.07248 20682.26
286.14026 23385.86
286.65518 20809.62
297.15582 21010.87
298.14026 33200.9
300.08258 44601.56
314.09821 24908.25
315.16629 30819.33
326.13516 10125.09
328.07828 11909.73
331.6958 20470.05
333.17706 146878.25
334.18039 20102.89
337.18729 34594.95
341.14624 10966.99
343.12527 11103.9
351.16797 46599.35
352.1698 11396.79
358.16132 135269.47
359.16406 21600.42
360.10349 11062.66
369.17746 102034.54
370.17902 21429.43
371.12012 32806.88
387.1882 77151.13
388.18484 21917.46
390.23532 46783.88
391.17227 40565.74
391.67328 21513.42
409.17212 33660.33
415.69855 37263.83
429.12555 19857.66
441.11124 10876.08
443.26135 27423.64
444.20993 19654.87
446.68848 12459.96
454.26633 10465.79
455.69312 32866.15
460.22247 47895.36
460.72424 21932.23
461.27234 103958.02
462.27487 28741.89
482.26157 23412.96
500.1629 33549.59
500.27151 11687.32
506.18835 21780.1
506.73343 8770
515.73773 27202.8
516.23743 20871.53
516.27771 18806.16
524.20032 59823.39
525.20233 10935.92
542.20953 19809.73
555.24011 30374.46
567.20624 11741.1
572.30371 25203.88
573.25409 33939.3
575.34991 20880.19
582.25793 10826.91
590.31641 79853.56
591.31702 33515.95
610.27478 11658.71
610.60809 34376.5
615.18854 11899.03
618.23535 10513.74
644.3728 10111.74
648.29932 10193.03
653.2392 21151.76
659.78137 11311.02
662.38416 98174.59
663.38538 26980.28
666.30927 32791.75
667.78809 24640.81
674.28119 50093.73
674.78082 34502.97
678.28656 19125.31
687.29462 34039.4
687.79401 45417.86
688.28607 31323.66
688.78448 12073.64
696.30005 200414.88
696.80261 143025.33
697.30426 43199.66
701.34998 39708.41
719.35822 144606.02
720.36151 54471.04
730.21802 10830.53
730.82379 18685.15
731.32288 21329.56
736.82782 11285.8
745.83453 89040.43
746.33282 41366.38
763.3255 22930.61
777.41168 54349.75
781.33496 75617.09
782.34088 19700.58
786.33844 47184.84
786.84222 39937.89
787.34155 21993.6
794.34326 10070
794.84515 19993.65
795.3432 53172.38
799.3476 36370.66
800.34912 25565.42
803.34668 53499.32
803.85187 51206.8
804.34662 23343.02
830.38843 48142.74
831.39264 20247.69
848.39966 132336.84
849.40424 52809.51
850.41388 12032.65
858.86475 49062.19
859.36639 47910.33
860.3689 11377.71
867.86584 36836.98
868.36902 22769.72
868.867 10605.43
874.42877 10820.84
879.30981 11015.28
892.44177 56379.67
901.42755 11376.77
910.37885 40027.22
911.38062 27208.89
919.43671 108090.62
920.44031 38047.75
928.38971 25195.18
981.4101 10634.47
1021.47913 32516.97
1022.47766 26643.26
1048.47559 21517.24
1117.39539 36977.6
1118.39038 18439.06
1150.52148 25354.75
1163.50281 11006.12
1391.59583 55018.36
1392.59521 29406.97
END IONS
BEGIN IONS
TITLE=260416_Sample5.10219.10219.2 (intensity=571352045.3956)
PEPMASS=558.289892131682
CHARGE=2+
SCANS=10219
RTINSECONDS=2108.208
101.07159 33280.3
102.05562 59365.45
110.07188 17722.1
112.05106 13311.26
112.08761 13796.05
129.06631 10676.29
129.10263 90158.05
130.08662 12849.84
131.11826 33103.15
136.07603 20312.92
147.11311 21061.19
152.05716 13321.23
158.09271 14445.38
167.08188 11433.5
175.11931 130583.87
176.12263 9887
183.1132 18289.15
197.12886 22600.59
201.12372 199991
202.12732 17868.06
215.13943 25408.51
224.10332 19732.12
225.12376 29797.02
229.11874 193850.3
230.07742 10412.54
230.12289 17890.84
232.11185 26093.25
239.15038 11763.91
240.13495 14549.33
241.0824 15297.33
242.15027 36686.89
244.16605 19590.94
257.16177 10049.02
258.10876 16243.46
272.17203 12433.41
273.12009 12045.95
290.14667 15119.94
295.177 16741.49
339.16614 2843
347.69986 10527.92
353.18268 13090.24
371.19308 23225.65
378.68622 22527.2
387.16306 21236.32
401.21481 10442.47
404.18964 40834.55
419.22519 12158.29
500.2464 10188.6
517.27405 69918.33
518.28162 13009.91
628.30682 17873.81
646.31665 93089.98
647.31879 33499.85
694.38885 19569.23
756.3631 18693.3
757.34863 44047.69
758.35175 21536.08
774.37469 77989.04
775.37738 36210.13
887.4588 111620.06
888.46204 51640.89
889.46545 11781.63
998.49414 12019.57
1016.50299 26308.21
1017.50378 17179.04
END IONS');
        
        return $tempFile;
    }
}
