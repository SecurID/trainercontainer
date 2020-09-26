<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Create Exercise') }}
                </h2>
            </div>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form method="POST" action="/exercises">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Name" name="name">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Focus" name="focus">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <input type="text" class="form-control" placeholder="Material" name="material">
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control" placeholder="Duration" name="duration">
                        </div>
                        <div class="col-2">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <textarea class="form-control" placeholder="Procedure" name="procedure"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <textarea class="form-control" placeholder="Coaching" name="coaching"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Drawing</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">Select File ...</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">Create Exercise</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
