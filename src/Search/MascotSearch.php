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
namespace pgb_liv\php_ms\Search;

use pgb_liv\php_ms\Search\Parameters\MascotSearchParameters;

/**
 * Client to perform Mascot search and results retrieval
 *
 * @author Andrew Collins
 */
class MascotSearch
{

    private $host;

    private $port;

    private $path;

    private $cookies = array();

    const FILE_NAME = 'filename';

    const MIME_TYPE = 'mime';

    const FILE_DATA = 'data';

    /**
     * Create a new instance of this class.
     * Must supply server details.
     *
     * @param string $host
     *            Server hostname or IP address
     * @param int $port
     *            Server port
     * @param string $path
     *            Path to base Mascot directory
     */
    public function __construct($host, $port, $path)
    {
        $this->host = $host;
        $this->port = $port;
        $this->path = $path;
    }

    private function getCookieHeader()
    {
        $cookiePairs = array();
        foreach ($this->cookies as $key => $value) {
            $cookiePairs[] = $key . '=' . $value;
        }
        
        return 'Cookie: ' . implode(';', $cookiePairs);
    }

    private function sendPost($path, $args)
    {
        $handle = fsockopen($this->host, $this->port);
        
        fwrite($handle, 'POST ' . $path . ' HTTP/1.1' . "\r\n");
        fwrite($handle, 'Host: ' . $this->host . "\r\n");
        
        if (! empty($this->cookies)) {
            fwrite($handle, $this->getCookieHeader() . "\r\n");
        }
        
        $boundary = '---------------------------' . mt_rand();
        
        $size = 0;
        foreach ($args as $key => $value) {
            $size += 2 + strlen($boundary) + 2;
            if (is_array($value) && $key == 'FILE') {
                $size += 38 + strlen($key) + 13 + strlen($value[MascotSearch::FILE_NAME]) + 3;
                $size += strlen($value[MascotSearch::MIME_TYPE]) + 4;
                $size += filesize($value[MascotSearch::FILE_DATA]) + 4;
            } elseif ($key == 'MODS' || $key == 'IT_MODS') {
                $size += 38 + strlen($key) + 5;
                foreach ($value as $modification) {
                    $size += strlen($modification->getName());
                    $size += 3 + count($modification->getResidues()) + 2;
                }
            } else {
                $size += 38 + strlen($key) + 5;
                $size += strlen($value) + 2;
            }
        }
        $size += 2 + strlen($boundary) + 4;
        
        fwrite($handle, 'Content-Type: multipart/form-data; boundary=' . $boundary . "\r\n");
        fwrite($handle, 'Content-Length: ' . $size . "\r\n\r\n");
        
        foreach ($args as $key => $value) {
            fwrite($handle, '--' . $boundary . "\r\n");
            
            if (is_array($value) && $key == 'FILE') {
                fwrite($handle, 
                    'Content-Disposition: form-data; name="' . $key . '"; filename="' . $value[MascotSearch::FILE_NAME] .
                         '"' . "\r\n");
                fwrite($handle, $value[MascotSearch::MIME_TYPE] . "\r\n\r\n");
                
                $fileHandle = fopen($value[MascotSearch::FILE_DATA], 'r');
                while (! feof($fileHandle)) {
                    fwrite($handle, fgets($fileHandle));
                }
                
                fclose($fileHandle);
                
                fwrite($handle, "\r\n\r\n");
            } elseif ($key == 'MODS' || $key == 'IT_MODS') {
                fwrite($handle, 'Content-Disposition: form-data; name="' . $key . '"' . "\r\n\r\n");
                
                foreach ($value as $modification) {
                    fwrite($handle, 
                        $modification->getName() . ' (' . implode('', $modification->getResidues()) . ")\r\n");
                }
            } else {
                fwrite($handle, 'Content-Disposition: form-data; name="' . $key . '"' . "\r\n\r\n");
                fwrite($handle, $value . "\r\n");
            }
        }
        
        fwrite($handle, '--' . $boundary . "--\r\n");
        
        return $this->readResponse($handle);
    }

    private function sendGet($path, $args)
    {
        $handle = fsockopen($this->host, $this->port);
        
        $queryString = '';
        $prefix = '?';
        foreach ($args as $key => $value) {
            $queryString .= $prefix . urlencode($key) . '=' . urlencode($value);
            
            if ($prefix == '?') {
                $prefix = '&';
            }
        }
        
        fwrite($handle, 'GET ' . $path . $queryString . ' HTTP/1.1' . "\r\n");
        fwrite($handle, 'Host: ' . $this->host . "\r\n");
        
        if (! empty($this->cookies)) {
            fwrite($handle, $this->getCookieHeader() . "\r\n\r\n");
        }
        
        return $this->readResponse($handle);
    }

    private function readResponse($socket)
    {
        $header = '';
        $content = '';
        $isHeader = true;
        $hasAttachment = false;
        $attachmentName = null;
        $tmpFile = null;
        
        while (! feof($socket)) {
            $line = fgets($socket);
            
            if ($isHeader) {
                if ($line == "\r\n") {
                    $isHeader = false;
                    continue;
                }
                
                if (stripos($line, 'Content-Disposition: attachment;') === 0) {
                    $hasAttachment = true;
                    $attachmentName = substr($line, 43, - 3);
                }
                
                $header .= $line;
            } elseif ($hasAttachment) {
                if (is_null($tmpFile)) {
                    $tmpFile = tempnam(sys_get_temp_dir(), 'mascot_attach_');
                    $tmpFileHandle = fopen($tmpFile, 'w');
                }
                
                fwrite($tmpFileHandle, $line);
            } else {
                $content .= $line;
            }
        }
        
        fclose($socket);
        
        if (! is_null($tmpFile)) {
            fclose($tmpFileHandle);
        }
        
        return array(
            'header' => $header,
            'content' => $content,
            'attachmentName' => $attachmentName,
            'attachmentFile' => $tmpFile
        );
    }

    public function authenticate($username, $password)
    {
        $args = array();
        $args['username'] = $username;
        $args['password'] = $password;
        $args['submit'] = 'Login';
        $args['display'] = 'logout_prompt';
        $args['savecookie'] = '1';
        $args['action'] = 'login';
        $args['userid'] = '';
        $args['onerrdisplay'] = 'login_prompt';
        
        $response = $this->sendPost($this->path . '/cgi/login.pl', $args);
        
        $this->cookies = array();
        foreach (explode("\n", $response['header']) as $line) {
            if (stripos($line, 'Set-Cookie:') === 0) {
                $cookie = substr($line, 12, stripos($line, ';') - 12);
                $parts = explode('=', $cookie);
                $this->cookies[$parts[0]] = $parts[1];
            }
        }
        
        return count($this->cookies) >= 3;
    }

    public function getXml($filePath)
    {
        $args = array();
        $args['file'] = $filePath;
        $args['do_export'] = '1';
        $args['prot_hit_num'] = '1';
        $args['prot_acc'] = '1';
        $args['pep_query'] = '1';
        $args['pep_rank'] = '1';
        $args['pep_isbold'] = '1';
        $args['pep_isunique'] = '1';
        $args['pep_exp_mz'] = '1';
        $args['_showallfromerrortolerant'] = '';
        $args['_onlyerrortolerant'] = '';
        $args['_noerrortolerant'] = '';
        $args['_show_decoy_report'] = '0';
        $args['sessionid'] = '';
        $args['export_format'] = 'XML';
        $args['_sigthreshold'] = '0.05';
        $args['_ignoreionsscorebelow'] = '0';
        $args['use_homology'] = '0';
        $args['report'] = 'AUTO';
        $args['_server_mudpit_switch'] = '0.000000001';
        $args['_showsubsets'] = '0';
        $args['search_master'] = '1';
        $args['show_header'] = '1';
        $args['show_decoy'] = '1';
        $args['show_mods'] = '1';
        $args['show_params'] = '1';
        $args['show_format'] = '1';
        $args['protein_master'] = '1';
        $args['prot_score'] = '1';
        $args['prot_desc'] = '1';
        $args['prot_mass'] = '1';
        $args['prot_matches'] = '1';
        $args['peptide_master'] = '1';
        $args['pep_exp_mr'] = '1';
        $args['pep_exp_z'] = '1';
        $args['pep_calc_mr'] = '1';
        $args['pep_calc_mr'] = '1';
        $args['pep_delta'] = '1';
        $args['pep_miss'] = '1';
        $args['pep_score'] = '1';
        $args['pep_expect'] = '1';
        $args['pep_seq'] = '1';
        $args['pep_var_mod'] = '1';
        $args['pep_scan_title'] = '1';
        
        $response = $this->sendPost($this->path . '/cgi/export_dat_2.pl', $args);
        
        return array(
            'name' => $response['attachmentName'],
            'path' => $response['attachmentFile']
        );
    }

    public function getSearches($limit)
    {
        $args = array();
        $args['CalledFromForm'] = 1;
        $args['logfile'] = '../logs/searches.log';
        $args['start'] = - 1;
        $args['howMany'] = $limit;
        $args['pathToData'] = '';
        $args['column'] = 0;
        $args['s0'] = 1;
        $args['s1'] = 1;
        $args['s2'] = 1;
        $args['s3'] = 1;
        $args['s4'] = 1;
        $args['s7'] = 1;
        $args['s8'] = 1;
        $args['s9'] = 1;
        $args['s10'] = 1;
        $args['s11'] = 1;
        $args['s12'] = 1;
        $args['s14'] = 1;
        $args['f0'] = '';
        $args['f1'] = '';
        $args['f2'] = '';
        $args['f3'] = '';
        $args['f4'] = '';
        $args['f5'] = '';
        $args['f6'] = '';
        $args['f7'] = '';
        $args['f8'] = '';
        $args['f9'] = '';
        $args['f10'] = '';
        $args['f11'] = '';
        $args['f12'] = '';
        $args['f13'] = '';
        $args['f14'] = '';
        
        $response = $this->sendGet($this->path . '/x-cgi/ms-review.exe', $args);
        
        $pattern = '/<TR>\s+<TD><A HREF="..\/cgi\/master_results_2.pl\?file=(?<filename>.*)">\s?(?<job>[0-9]+)<\/A><\/TD>\s+<TD>\s?(?<pid>[0-9]+)<\/TD>\s+<TD>(?<dbase>.+)<\/TD>\s+<TD>(?<username>.*)<\/TD>\s*<TD>(?<email>.*)<\/TD>\s+<TD>(?<ti>.*)<\/TD>\s+<TD>.*<\/TD>\s+<TD NOWRAP>(?<start_time>.+)<\/TD>\s+<TD>\s*(?<dur>[0-9]+)<\/TD>\s+<TD>(?<status>.+)<\/TD>\s+<TD>(?<pr>.+)<\/TD>\s+<TD>(?<typ>.+)<\/TD>\s+<TD>(?<enzyme>.+)<\/TD>\s+<TD>\s?(?<ip>[0-9]*)<\/TD>\s+<TD>\s?(?<userid>[0-9]+)<\/TD>/sU';
        preg_match_all($pattern, $response['content'], $matches);
        
        $searchLog = array();
        for ($i = 0; $i < count($matches['filename']); $i ++) {
            $searchLog[$i] = array();
            $searchLog[$i]['filename'] = $matches['filename'][$i];
            $searchLog[$i]['job'] = $matches['job'][$i];
            $searchLog[$i]['pid'] = $matches['pid'][$i];
            $searchLog[$i]['dbase'] = $matches['dbase'][$i];
            $searchLog[$i]['username'] = $matches['username'][$i];
            $searchLog[$i]['email'] = $matches['email'][$i];
            $searchLog[$i]['ti'] = $matches['ti'][$i];
            $searchLog[$i]['start_time'] = $matches['start_time'][$i];
            $searchLog[$i]['dur'] = $matches['dur'][$i];
            $searchLog[$i]['status'] = $matches['status'][$i];
            $searchLog[$i]['typ'] = $matches['typ'][$i];
            $searchLog[$i]['enzyme'] = $matches['enzyme'][$i];
            $searchLog[$i]['ip'] = $matches['ip'][$i];
            $searchLog[$i]['userid'] = $matches['userid'][$i];
        }
        
        return $searchLog;
    }

    public function search(MascotSearchParameters $params)
    {
        $args = array();
        $args['INTERMEDIATE'] = $params->getIntermediate();
        $args['FORMVER'] = $params->getFormVersion();
        $args['SEARCH'] = $params->getSearchType();
        $args['PEAK'] = $params->getPeak();
        $args['REPTYPE'] = $params->getRepType();
        $args['ErrTolRepeat'] = $params->getErrorTolerantRepeat();
        $args['SHOWALLMODS'] = $params->isShowAllModsEnabled();
        $args['USERNAME'] = $params->getUserName();
        $args['USEREMAIL'] = $params->getUserMail();
        $args['COM'] = $params->getTitle();
        $args['DB'] = $params->getDatabases();
        $args['CLE'] = $params->getEnzyme();
        $args['PFA'] = $params->getMissedCleavageCount();
        $args['QUANTITATION'] = $params->getQuantitation();
        $args['TAXONOMY'] = $params->getTaxonomy();
        $args['MODS'] = $params->getFixedModifications();
        $args['IT_MODS'] = $params->getVariableModifications();
        $args['TOL'] = $params->getPrecursorTolerance()->getTolerance();
        $args['TOLU'] = $params->getPrecursorTolerance()->getUnit();
        $args['PEP_ISOTOPE_ERROR'] = $params->getPeptideIsotopeError();
        $args['ITOL'] = $params->getFragmentTolerance()->getTolerance();
        $args['ITOLU'] = $params->getFragmentTolerance()->getUnit();
        $args['CHARGE'] = $params->getCharge();
        $args['MASS'] = $params->getMassType();
        $args['FILE'] = array(
            MascotSearch::FILE_NAME => basename($params->getSpectraPath()),
            MascotSearch::MIME_TYPE => 'Content-Type: application/octet-stream',
            MascotSearch::FILE_DATA => $params->getSpectraPath()
        );
        $args['FORMAT'] = $params->getFileFormat();
        $args['PRECURSOR'] = $params->getPrecursor();
        $args['INSTRUMENT'] = $params->getInstrument();
        $args['DECOY'] = $params->isDecoyEnabled();
        $args['REPORT'] = $params->getReport();
        
        $response = $this->sendPost($this->path . '/cgi/nph-mascot.exe?1', $args);
        
        // Extract .dat path
        preg_match('/master_results\\.pl\\?file=(.*[0-9]+\\/F[0-9]+\\.dat)/', $response['content'], $matches);
        
        return $matches[1];
    }
}
