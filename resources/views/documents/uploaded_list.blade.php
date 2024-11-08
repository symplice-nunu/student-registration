@extends('layouts.app')

@section('content')
<div class="h-screen mx-auto p-4">
    <h1 class="text-2xl text-center font-bold mb-4">Document List</h1>
    <!-- Success Message -->
    @if ($message = Session::get('success'))
        <div class="bg-green-500 text-center text-white p-2 rounded mb-4">
            {{ $message }}
        </div>
    @endif
    @can('document-create')
    <div class="mt-4 text-right mb-4">
        <a href="{{ route('documents.upload') }}" class="bg-teal-500 text-white py-2 px-8 rounded hover:bg-teal-600">Upload More Documents</a>
    </div>
    @endcan
    @can('document-list')
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 text-left border-b">Document Name</th>
                    @can('document-edit')
                    <th class="py-2 px-4 border-b">Actions</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($documents as $document)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b">{{ $document->name }}</td>
                        <td class="py-2 px-4 text-center w-[350px] border-b">
                            <div class="md:flex gap-3">
                            @can('document-edit')
                                <div class="bg-blue-500 w-full rounded hover:bg-blue-600 py-1">
                                    <a href="#" onclick="openModal('{{ Storage::url($document->path) }}'); return false;" class="text-white">View</a>
                                </div>
                                <div class="bg-green-500 rounded w-full hover:bg-green-600 py-1">
                                    <a href="{{ Storage::url($document->path) }}" class="text-white" download>Download</a>
                                </div>
                                @endcan
                                
                                @can('document-edit')
                                <div class="bg-red-500 rounded w-full hover:bg-red-600 py-1">
                                    <form action="{{ route('documents.destroy', $document->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-white">Delete</button>
                                    </form>
                                </div>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endcan

    <div class="mt-4">
        {{ $documents->links() }}
    </div>
</div>

<!-- Modal Structure -->
<div id="fileModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="bg-white h-screen rounded-lg shadow-lg p-4 max-w-7xl w-full">
        <button id="closeModal" class="absolute top-2 right-2 text-gray-600">&times;</button>
        <h2 class="text-lg font-semibold mb-2">Document Preview</h2>
        <iframe id="fileViewer" class="w-full h-[740px]" frameborder="0"></iframe>
    </div>
</div>

<script>
    function openModal(fileUrl) {
        document.getElementById('fileViewer').src = fileUrl;
        document.getElementById('fileModal').classList.remove('hidden');
    }

    document.getElementById('closeModal').addEventListener('click', function () {
        document.getElementById('fileModal').classList.add('hidden');
        document.getElementById('fileViewer').src = '';
    });

    window.addEventListener('click', function (event) {
        const modal = document.getElementById('fileModal');
        if (event.target === modal) {
            modal.classList.add('hidden');
            document.getElementById('fileViewer').src = '';
        }
    });
</script>
@endsection
