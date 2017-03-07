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

/**
 * A FASTA parser that creates a new iterable object that will return a database
 * entry on each iteration.
 *
 * @author Andrew Collins
 */
class MascotSearch
{

    private $host;

    private $port;

    private $cookies = array();

    /**
     * Create a new instance of this class.
     * Must supply server details.
     *
     * @param string $host
     *            Server hostname or IP address
     * @param int $port
     *            Server port
     */
    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;
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
        
        $boundary = '---------------------------8793238275072';
        $data = '';
        foreach ($args as $key => $value) {
            $data .= '--' . $boundary . "\r\n";
            $data .= 'Content-Disposition: form-data; name="' . $key . '"' . "\r\n\r\n";
            $data .= $value . "\r\n";
        }
        $data .= '--' . $boundary . "--\r\n";
        
        fwrite($handle, 'Content-Type: multipart/form-data; boundary=' . $boundary . "\r\n");
        fwrite($handle, 'Content-Length: ' . strlen($data) . "\r\n\r\n");
        fwrite($handle, $data . "\r\n");
        
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
        
        $response = $this->sendPost('/mascot/cgi/login.pl', $args);
        
        $this->cookies = array();
        foreach (explode("\n", $response['header']) as $line) {
            if (stripos($line, 'Set-Cookie:') === 0) {
                $cookie = substr($line, 12, stripos($line, ';') - 12);
                $parts = explode('=', $cookie);
                $this->cookies[$parts[0]] = $parts[1];
            }
        }
        
        return is_array($this->cookies);
    }

    function getXml($filePath)
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
        
        $response = $this->sendPost('/mascot/cgi/export_dat_2.pl', $args);
        
        return array(
            'name' => $response['attachmentName'],
            'path' => $response['attachmentFile']
        );
    }

    function getSearches($limit)
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
        
        $response = $this->sendGet('/mascot/x-cgi/ms-review.exe', $args);
        
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
}