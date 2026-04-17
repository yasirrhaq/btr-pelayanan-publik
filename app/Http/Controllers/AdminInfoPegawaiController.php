<?php

namespace App\Http\Controllers;

use App\Models\InfoPegawai;
use Illuminate\Http\Request;

class AdminInfoPegawaiController extends Controller
{
    protected $redirect_path = '/dashboard/info-pegawai';
    protected $path_file_save = 'info-pegawai';

    protected function deleteImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        $absolute = public_path(ltrim(str_replace('\\', '/', $path), '/'));

        if (is_file($absolute)) {
            @unlink($absolute);
        }
    }

    protected function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'urutan' => 'nullable|integer|min:1',
            'nip' => 'nullable|max:100',
            'jenis_kepegawaian' => 'nullable|max:100',
            'pangkat_golongan' => 'nullable|max:150',
            'jabatan' => 'nullable|max:255',
            'instansi' => 'nullable|max:255',
            'email' => 'nullable|email|max:255',
            'path_image' => 'nullable|image|file|max:1024',
            'remove_image' => 'nullable|boolean',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = InfoPegawai::query();

        if ($search = request('search')) {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('title', 'like', '%' . $search . '%')
                    ->orWhere('jabatan', 'like', '%' . $search . '%')
                    ->orWhere('pangkat_golongan', 'like', '%' . $search . '%')
                    ->orWhere('jenis_kepegawaian', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $infoPegawai = $query
            ->orderBy('urutan')
            ->orderBy('title')
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.info-pegawai.index', compact('infoPegawai'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.info-pegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->rules());

        if (empty($validatedData['urutan'])) {
            unset($validatedData['urutan']);
        }

        if ($request->file('path_image')) {

            $slug      = slugCustom($request->title);
            $file      = $request->file() ?? [];
            $path      = 'uploads/'.$this->path_file_save.'/';
            $config_file = [
                'patern_filename'   => $slug,
                'is_convert'        => true,
                'file'              => $file,
                'path'              => $path,
                'convert_extention' => 'jpeg'
            ];

            $validatedData['path_image'] = (new \App\Http\Controllers\Functions\ImageUpload())->imageUpload('file', $config_file)['path_image'];
        }

        $validatedData['created_by'] = auth()->id();
        InfoPegawai::create($validatedData);
        return redirect($this->redirect_path)->with('success', 'Berhasil menambahkan Data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $infoPegawai = InfoPegawai::find($id);
        return view('dashboard.info-pegawai.show', [
            'infoPegawai' => $infoPegawai
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $infoPegawai = InfoPegawai::find($id);
        return view('dashboard.info-pegawai.edit',compact(
            'infoPegawai'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate($this->rules());
        $info_pegawai = InfoPegawai::where('id', $id)->first();

        if (empty($validatedData['urutan'])) {
            unset($validatedData['urutan']);
        }

        if ((int) ($validatedData['remove_image'] ?? 0) === 1 && !$request->file('path_image')) {
            $this->deleteImage($info_pegawai->path_image);
            $validatedData['path_image'] = '';
        }

        if ($request->file('path_image')) {
            $this->deleteImage($info_pegawai->path_image);

            $slug      = slugCustom($request->title);
            $file      = $request->file() ?? [];
            $path      = 'uploads/'.$this->path_file_save.'/';
            $config_file = [
                'patern_filename'   => $slug,
                'is_convert'        => true,
                'file'              => $file,
                'path'              => $path,
                'convert_extention' => 'jpeg'
            ];

            $validatedData['path_image'] = (new \App\Http\Controllers\Functions\ImageUpload())->imageUpload('file', $config_file)['path_image'];
        }

        unset($validatedData['remove_image']);
        $validatedData['updated_by'] = auth()->id();

        $info_pegawai = $info_pegawai
            ->update($validatedData);
        return redirect($this->redirect_path)->with('success', 'Info pegawai berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $infoPegawai = InfoPegawai::find($id);
        $this->deleteImage($infoPegawai->path_image);
        $infoPegawai->delete();
        return redirect($this->redirect_path)->with('success', 'Info pegawai berhasil dihapus!');
    }
}
