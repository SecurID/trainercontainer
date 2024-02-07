<div class="flex justify-between items-center space-x-1">
    <!-- Strongly Negative -->
    <label class="group relative cursor-pointer">
        <input type="radio" name="rating{{$player->id}}" class="hidden"
               autocomplete="off" value="1" aria-label="Strongly negative">
        <span
            class="inline-flex items-center px-3 py-1 rounded-full bg-red-600 text-white">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M8.22602 19.6119C7.85236 21.3557 9.18165 23 10.965 23C11.6089 23 12.2073 22.6683 12.5486 22.1223L17 15H20C21.1046 15 22 14.1046 22 13V5C22 3.89543 21.1046 3 20 3H5.8541C4.71779 3 3.679 3.64201 3.17082 4.65836L1.42229 8.15542C1.14458 8.71084 1 9.32329 1 9.94427V13C1 14.6569 2.34315 16 4 16H9L8.22602 19.6119ZM17 5V13H20V5H17ZM10.8935 20.9969L15 14.4264V5H5.8541C5.47533 5 5.12907 5.214 4.95968 5.55279L3.21115 9.04984C3.07229 9.32756 3 9.63378 3 9.94427V13C3 13.5523 3.44772 14 4 14H9C9.60399 14 10.1756 14.2729 10.5553 14.7426C10.935 15.2123 11.0822 15.8285 10.9556 16.4191L10.1816 20.031C10.0798 20.5061 10.42 20.9554 10.8935 20.9969Z"
                  fill="black"/>
            </svg>
        </span>
        <span
            class="absolute bottom-full mb-2 hidden w-auto p-2 text-xs text-white bg-black rounded-md shadow-lg group-hover:block">Strongly Negative</span>
    </label>

    <!-- Negative -->
    <label class="group relative cursor-pointer">
        <input type="radio" name="rating{{$player->id}}" class="hidden"
               autocomplete="off" value="2" aria-label="Negative">
        <span
            class="inline-flex items-center px-3 py-1 rounded-full bg-red-400 text-white">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
            <path
                d="M10.5 10C10.5 10.8284 9.82843 11.5 9 11.5C8.17157 11.5 7.5 10.8284 7.5 10C7.5 9.17157 8.17157 8.5 9 8.5C9.82843 8.5 10.5 9.17157 10.5 10Z"
                fill="black"/>
            <path
                d="M16.5 10C16.5 10.8284 15.8284 11.5 15 11.5C14.1716 11.5 13.5 10.8284 13.5 10C13.5 9.17157 14.1716 8.5 15 8.5C15.8284 8.5 16.5 9.17157 16.5 10Z"
                fill="black"/>
            <path
                d="M13.9654 15.7332C14.3825 16.0952 14.9868 16.2765 15.4649 16C15.9429 15.7235 16.1127 15.103 15.7468 14.6893C14.8316 13.6543 13.4926 13 12 13C10.5074 13 9.16847 13.6543 8.25322 14.6893C7.88735 15.103 8.05708 15.7235 8.53514 16C9.01321 16.2765 9.61754 16.0952 10.0346 15.7332C10.5616 15.2758 11.2489 15 12 15C12.7511 15 13.4384 15.2758 13.9654 15.7332Z"
                fill="black"/>
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20Z"
                  fill="black"/>
            </svg>
        </span>
        <span
            class="absolute bottom-full mb-2 hidden w-auto p-2 text-xs text-white bg-black rounded-md shadow-lg group-hover:block">Negative</span>
    </label>

    <!-- Neutral -->
    <label class="group relative cursor-pointer">
        <input type="radio" name="rating{{$player->id}}" class="hidden"
               autocomplete="off" value="3" aria-label="Neutral" checked>
        <span
            class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-500 text-white">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
            <path
                d="M10.5 10C10.5 10.8284 9.82843 11.5 9 11.5C8.17157 11.5 7.5 10.8284 7.5 10C7.5 9.17157 8.17157 8.5 9 8.5C9.82843 8.5 10.5 9.17157 10.5 10Z"
                fill="black"/>
            <path
                d="M15 11.5C15.8284 11.5 16.5 10.8284 16.5 10C16.5 9.17157 15.8284 8.5 15 8.5C14.1716 8.5 13.5 9.17157 13.5 10C13.5 10.8284 14.1716 11.5 15 11.5Z"
                fill="black"/>
            <path
                d="M8 15C8 14.4477 8.44772 14 9 14H15C15.5523 14 16 14.4477 16 15C16 15.5523 15.5523 16 15 16H9C8.44772 16 8 15.5523 8 15Z"
                fill="black"/>
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20Z"
                  fill="black"/>
            </svg>

        </span>
        <span
            class="absolute bottom-full mb-2 hidden w-auto p-2 text-xs text-white bg-black rounded-md shadow-lg group-hover:block">Neutral</span>
    </label>

    <!-- Positive -->
    <label class="group relative cursor-pointer">
        <input type="radio" name="rating{{$player->id}}" class="hidden"
               autocomplete="off" value="4" aria-label="Positive">
        <span
            class="inline-flex items-center px-3 py-1 rounded-full bg-blue-400 text-white">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
            <path
                d="M10.5 10C10.5 10.8284 9.82843 11.5 9 11.5C8.17157 11.5 7.5 10.8284 7.5 10C7.5 9.17157 8.17157 8.5 9 8.5C9.82843 8.5 10.5 9.17157 10.5 10Z"
                fill="black"/>
            <path
                d="M15 11.5C15.8284 11.5 16.5 10.8284 16.5 10C16.5 9.17157 15.8284 8.5 15 8.5C14.1716 8.5 13.5 9.17157 13.5 10C13.5 10.8284 14.1716 11.5 15 11.5Z"
                fill="black"/>
            <path
                d="M8.53513 14C9.01319 13.7235 9.61753 13.9048 10.0346 14.2668C10.5616 14.7242 11.2489 15 12 15C12.7511 15 13.4384 14.7242 13.9654 14.2668C14.3825 13.9048 14.9868 13.7235 15.4649 14C15.9429 14.2765 16.1127 14.897 15.7468 15.3107C14.8315 16.3457 13.4926 17 12 17C10.5074 17 9.16846 16.3457 8.2532 15.3107C7.88734 14.897 8.05707 14.2765 8.53513 14Z"
                fill="black"/>
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20Z"
                  fill="black"/>
            </svg>
        </span>
        <span
            class="absolute bottom-full mb-2 hidden w-auto p-2 text-xs text-white bg-black rounded-md shadow-lg group-hover:block">Positive</span>
    </label>

    <!-- Strongly Positive -->
    <label class="group relative cursor-pointer">
        <input type="radio" name="rating{{$player->id}}" class="hidden"
               autocomplete="off" value="5" aria-label="Strongly positive">
        <span
            class="inline-flex items-center px-3 py-1 rounded-full bg-blue-600 text-white">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M15.774 4.38807L15 8H20C21.6569 8 23 9.34315 23 11V14.0557C23 14.6767 22.8554 15.2892 22.5777 15.8446L20.8292 19.3416C20.321 20.358 19.2822 21 18.1459 21H4C2.89543 21 2 20.1046 2 19V11C2 9.89543 2.89543 9 4 9H7L11.4514 1.87769C11.7927 1.33169 12.3911 1 13.035 1C14.8184 1 16.1476 2.64432 15.774 4.38807ZM7 11H4L4 19H7V11ZM19.0403 18.4472C18.8709 18.786 18.5247 19 18.1459 19H9V9.57359L13.1065 3.00312C13.58 3.04459 13.9202 3.4939 13.8184 3.96901L13.0444 7.58094C12.9178 8.17152 13.065 8.78766 13.4447 9.25736C13.8244 9.72705 14.396 10 15 10H20C20.5523 10 21 10.4477 21 11V14.0557C21 14.3662 20.9277 14.6724 20.7889 14.9502L19.0403 18.4472Z"
                  fill="black"/>
            </svg>
        </span>
        <span
            class="absolute bottom-full mb-2 hidden w-auto p-2 text-xs text-white bg-black rounded-md shadow-lg group-hover:block">Strongly Positive</span>
    </label>
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/datepicker.min.js"></script>
@endpush
