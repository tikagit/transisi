<?php
	public function cetakDataPegawai(Request $request)
            $id_unit_kerja = \Request::input('id_unit_kerja', null);
            $id_jabatan = \Request::input('id_jabatan', null);
            $id_status_pegawai = \Request::input('id_status_pegawai', null);
            $aktif = \Request::input('aktif', null);

            $agent = new Agent();
            $browser = $agent->browser();
            $version_browser = $agent->version($browser);

            $platform = $agent->platform();
            $version_platform = $agent->version($platform);

            if($platform == 'Windows'){
                $ext = 'xlsx';
            }else{
                $ext = 'xls';
            }

            $data = Pegawai::select(\DB::raw('pegawai.nip,pegawai.nik, pegawai.nama_lengkap, jabatan.jabatan, unit_kerja.unit_kerja, golongan.golongan, level.level, status_pegawai.status, pegawai.tgl_bergabung, pegawai.lama_kerja, pegawai.tgl_habis_kontrak, pegawai.no_sk, pegawai.tgl_sk, pegawai.nik, pegawai.alamat_ktp, pegawai.alamat_domisili, pegawai.no_kk, pegawai.tempat_lahir, pegawai.tanggal_lahir, agama.agama, jenis_kelamin.jenis_kelamin, golongan_darah.golongan_darah, status_pernikahan.status_pernikahan, jenjang.nama_jenjang, pegawai.no_bpjs_kes, pegawai.no_bpjs_ket, pegawai.no_hp, pegawai.email, pegawai.status_resign, pegawai.tgl_resign'))
            ->leftjoin('jabatan', 'jabatan.id', '=', 'pegawai.id_jabatan')
            ->leftjoin('golongan', 'golongan.id', '=', 'pegawai.id_golongan')
            ->leftjoin('status_pernikahan', 'status_pernikahan.id', '=', 'pegawai.id_status_pernikahan')
            ->leftjoin(\DB::raw("(select pendidikan.id, pendidikan.id_pegawai, pendidikan.id_jenjang, max(pendidikan.id_jenjang)
                from pendidikan group by pendidikan.id_pegawai
            )  pendidikan"),'pendidikan.id_pegawai','=','pegawai.id')
            ->leftjoin('jenjang','jenjang.id','=','pendidikan.id_jenjang')
            ->leftjoin('agama','agama.id','=','pegawai.id_agama')
            ->join('users', 'users.id_pegawai', '=', 'pegawai.id')
            ->where(function ($q) use ($id_unit_kerja, $id_jabatan, $id_status_pegawai, $aktif, $tidak_aktif, $tahunPensiun, $kelengkapan) {
                if (!empty($id_unit_kerja)) {
                    $q->where('pegawai.id_unit_kerja', $id_unit_kerja);
                }
                if (!empty($id_jabatan)) {
                    $q->where('pegawai.id_jabatan', $id_jabatan);
                }
                if (!empty($id_status_pegawai)) {
                    $q->where('pegawai.id_status_pegawai', $id_status_pegawai);
                }
                if (!empty($aktif)) {
                    $q->where('pegawai.status_resign', $aktif);
                }
                if (!empty($tidak_aktif)) {
                    $q->where('pegawai.status_resign', $tidak_aktif);
                }
                if (!empty($tahunPensiun)) {
                    $lim_pension = Perusahaan::select(\DB::raw('lim_pension'))->first();
                    $cek_tahun = $tahunPensiun-$lim_pension['lim_pension'];
                        // dd($cek_tahun);
                    $q->whereYear('pegawai.tanggal_lahir', ($cek_tahun));
                }
                if (!empty($tahunKontrak)) {
                    $q->whereYear('pegawai.tgl_resign', ($tahunKontrak));
                }
            })
            ->whereNotIn('users.username',getConfigValues('USER_DEFAULT'))
            ->orderby('pegawai.nama_lengkap', 'ASC')
            ->get();
            // dd($data);


            if (!empty($kelengkapan)) {
                $data = Pegawai::select(\DB::raw('pegawai.id as id_pegawai, pegawai.nip,pegawai.nik, pegawai.nama_lengkap, jabatan.jabatan, unit_kerja.unit_kerja, golongan.golongan, level.level, status_pegawai.status, pegawai.tgl_bergabung, pegawai.lama_kerja, pegawai.tgl_habis_kontrak, pegawai.no_sk, pegawai.tgl_sk, pegawai.nik, pegawai.alamat_ktp, pegawai.alamat_domisili, pegawai.no_kk, pegawai.tempat_lahir, pegawai.tanggal_lahir, agama.agama, jenis_kelamin.jenis_kelamin, golongan_darah.golongan_darah, status_pernikahan.status_pernikahan, jenjang.nama_jenjang, pegawai.no_bpjs_kes, pegawai.no_bpjs_ket, pegawai.no_hp, pegawai.email, pegawai.status_resign, pegawai.tgl_resign'))
                ->leftjoin('jabatan', 'jabatan.id', '=', 'pegawai.id_jabatan')
                ->leftjoin('golongan', 'golongan.id', '=', 'pegawai.id_golongan')
                ->leftjoin('status_pernikahan', 'status_pernikahan.id', '=', 'pegawai.id_status_pernikahan')

                ->leftjoin('unit_kerja','unit_kerja.id','=','pegawai.id_unit_kerja')
                ->leftjoin('level','level.id','=','pegawai.id_level')
                ->leftjoin('status_pegawai','status_pegawai.id','=','pegawai.id_status_pegawai')
                ->leftjoin('jenis_kelamin','jenis_kelamin.id','=','pegawai.id_jenis_kelamin')
                ->leftjoin('golongan_darah','golongan_darah.id','=','pegawai.id_golongan_darah')
                ->leftjoin(\DB::raw("(select pendidikan.id, pendidikan.id_pegawai, pendidikan.id_jenjang, max(pendidikan.id_jenjang)
                    from pendidikan group by pendidikan.id_pegawai
                )  pendidikan"),'pendidikan.id_pegawai','=','pegawai.id')
                ->leftjoin('jenjang','jenjang.id','=','pendidikan.id_jenjang')
                ->leftjoin('agama','agama.id','=','pegawai.id_agama')
                ->join('users', 'users.id_pegawai', '=', 'pegawai.id')
                ->whereNotIn('users.username',getConfigValues('USER_DEFAULT'))
                ->orderby('pegawai.nama_lengkap', 'ASC')
                ->get();
             }


            return Excel::create('Employee Master_Data_'.date('Y-m-d H:i:s'), function($excel) use ($data) {
                $excel->sheet('Sheet 1', function($sheet) use ($data)
                {
                    $sheet->loadView('pegawai.print-data-pegawai-excel')->with('data',$data);
                    $sheet->setColumnFormat(array(
                        'N' => \PHPExcel_Style_NumberFormat::FORMAT_NUMBER,
                        'Q' => \PHPExcel_Style_NumberFormat::FORMAT_NUMBER,
                        'Z' => \PHPExcel_Style_NumberFormat::FORMAT_NUMBER,
                        'AA' => \PHPExcel_Style_NumberFormat::FORMAT_NUMBER,
                        'AB' => \PHPExcel_Style_NumberFormat::FORMAT_NUMBER
                    ));
                });
            })->download('xlsx');
            // $this->load->library('PHPExcel/IOFactory.php');
        }
?>