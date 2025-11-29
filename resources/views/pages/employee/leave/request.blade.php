@extends('layouts.dashboard')
@section('title', 'Request Leave')

@section('content')
    <div class="space-y-4">
        <div class="flex items-center gap-4">
            <x-button href="{{ route('dashboard.employee.leave.index') }}" variant="secondary" :isIcon="true">
                <i class="fa-solid fa-arrow-left"></i>
            </x-button>
            <x-text as="h1" variant="h2">Request Leave</x-text>
        </div>

        @if(session('error'))
            <x-alert variant="danger" :dismissible="true">
                <span class="font-medium">Error!</span> {{ session('error') }}
            </x-alert>
        @endif

        {{-- Request Form --}}
        <x-card>
            <x-text as="h3" variant="h4" class="mb-6">Leave Request Form</x-text>

            <form action="{{ route('dashboard.employee.leave.store') }}" method="POST" class="space-y-6">
                @csrf

                <fieldset class="space-y-4">
                    {{-- Leave Type --}}
                    <x-select id="leave_type" name="leave_type" label="Leave Type"
                        error="{{ $errors->first('leave_type') }}" required>
                        <option value="" selected disabled>Select leave type</option>

                        @if($leaveBalance->annual_leave_balance > 0)
                            <option value="annual" {{ old('leave_type') === 'annual' ? 'selected' : '' }}>
                                Annual Leave ({{ $leaveBalance->annual_leave_balance }} days available)
                            </option>
                        @endif

                        @if($leaveBalance->sick_leave_balance > 0)
                            <option value="sick" {{ old('leave_type') === 'sick' ? 'selected' : '' }}>
                                Sick Leave ({{ $leaveBalance->sick_leave_balance }} days available)
                            </option>
                        @endif

                        @if($leaveBalance->personal_leave_balance > 0)
                            <option value="personal" {{ old('leave_type') === 'personal' ? 'selected' : '' }}>
                                Personal Leave ({{ $leaveBalance->personal_leave_balance }} days available)
                            </option>
                        @endif
                    </x-select>

                    @if($leaveBalance->annual_leave_balance <= 0 && $leaveBalance->sick_leave_balance <= 0 && $leaveBalance->personal_leave_balance <= 0)
                        <div class="p-4 bg-warning/10 border border-warning/20 rounded-lg">
                            <x-text as="p" class="text-warning">
                                <i class="fa-solid fa-exclamation-triangle"></i>
                                You have no available leave balance. Please contact HR for assistance.
                            </x-text>
                        </div>
                    @endif

                    {{-- Date Range --}}
                    <x-date-picker 
                        :range="true" 
                        label="Leave Period"
                        id="leave_period"
                        startName="start_date"
                        endName="end_date"
                        startPlaceholder="Start date"
                        endPlaceholder="End date"
                        :startValue="old('start_date', '')"
                        :endValue="old('end_date', '')"
                        :startError="$errors->first('start_date')"
                        :endError="$errors->first('end_date')"
                        :required="true"
                    />

                    {{-- Reason --}}
                    <x-input id="reason" name="reason" type="textarea" label="Reason"
                        placeholder="Please provide a reason for your leave request..."
                        error="{{ $errors->first('reason') }}" value="{{ old('reason') }}" required />

                    {{-- Info Box --}}
                    <div class="p-4 bg-blue-500/10 border border-blue-500/20 rounded-lg">
                        <x-text as="small" class="text-blue-600 dark:text-blue-400">
                            <i class="fa-solid fa-info-circle"></i>
                            <strong>Note:</strong> Your leave request will be reviewed by the admin. You will be notified
                            once it has been approved or rejected.
                        </x-text>
                    </div>
                </fieldset>

                {{-- Submit Buttons --}}
                <div class="flex gap-4">
                    <x-button href="{{ route('dashboard.employee.leave.index') }}" variant="secondary" class="ml-auto">
                        Cancel
                    </x-button>
                    <x-button type="submit" :disabled="$leaveBalance->annual_leave_balance <= 0 && $leaveBalance->sick_leave_balance <= 0 && $leaveBalance->personal_leave_balance <= 0">
                        <i class="fa-solid fa-paper-plane"></i>
                        Submit Request
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
