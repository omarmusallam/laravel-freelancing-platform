<x-app-layout>
    @php($pageMode = 'create')
    <form action="{{ route('client.projects.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('client.projects._form')
    </form>
</x-app-layout>
