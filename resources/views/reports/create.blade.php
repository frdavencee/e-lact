@extends('layouts.app')

@section('title', 'Buat Laporan Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="detail-card">
            <div class="detail-card-header">
                <h5>Buat Laporan Baru</h5>
            </div>
            <div class="detail-card-body">
                <form method="POST" action="{{ route('reports.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label-soft">Proyek <span class="text-danger">*</span></label>
                            <select name="project_id" class="form-select-soft" required>
                                <option value="">-- Pilih Proyek --</option>
                                @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }} ({{ $project->location->name ?? 'No Location' }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-soft">Judul Laporan <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control-soft" required value="{{ old('title') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-soft">Jenis Laporan</label>
                            <select name="type" class="form-select-soft">
                                <option value="lapangan" {{ old('type') == 'lapangan' ? 'selected' : '' }}>Laporan Lapangan</option>
                                <option value="teknis" {{ old('type') == 'teknis' ? 'selected' : '' }}>Laporan Teknis</option>
                                <option value="pemantauan" {{ old('type') == 'pemantauan' ? 'selected' : '' }}>Laporan Pemantauan</option>
                                <option value="lainnya" {{ old('type') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-soft">Tanggal Laporan</label>
                            <input type="date" name="report_date" class="form-control-soft" value="{{ old('report_date', date('Y-m-d')) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-soft">Lokasi</label>
                            <input type="text" name="location" class="form-control-soft" value="{{ old('location') }}" placeholder="Alamat lokasi">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-soft">Nama Staff PD</label>
                            <input type="text" name="pd_staff" class="form-control-soft" value="{{ old('pd_staff') }}" placeholder="Nama staf pengawas">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label-soft">Deskripsi</label>
                            <textarea name="description" class="form-control-soft" rows="3" placeholder="Deskripsi singkat laporan">{{ old('description') }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label-soft">Temuan</label>
                            <textarea name="findings" class="form-control-soft" rows="4" placeholder="Temuan dari lapangan">{{ old('findings') }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label-soft">Rekomendasi</label>
                            <textarea name="recommendations" class="form-control-soft" rows="4" placeholder="Rekomendasi">{{ old('recommendations') }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label-soft">Rencana Tindak Lanjut</label>
                            <textarea name="action_plan" class="form-control-soft" rows="4" placeholder="Rencana tindak lanjut">{{ old('action_plan') }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('reports.index') }}" class="btn-soft-secondary">Batal</a>
                                <button type="submit" class="btn-primary-gradient">Simpan Laporan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
