@extends('layouts.admin')

@section('title')
    <div class="flex items-center">
        <div class="flex-1 text-left pl-10 lg:pl-0">Products</div>
        <x-secondary-button adminDashboard="true" onclick="showAddProductForm()" class="font-lexend text-base">Add new
            product</x-secondary-button>
    </div>
@endsection

@section('content')
    {{-- form overlay, basically make everything dark behind the form --}}
    <div id="formOverlay"
        class="z-40 hidden absolute top-0 left-0 lg:hidden w-full h-screen opacity-50 bg-default-black transition-all duration-150 ease-in-out">
    </div>

    <div class="w-full h-full">


        {{-- 2 column gird --}}
        <div class=" grid grid-cols-2 grid-rows-1 gap-4 h-full w-full px-5  sm:px-8">
            <div id="productsTable" class="lg:col-span-2 rounded-lg overflow-hidden lg:col-span-1 col-span-2">
                <div class="rounded-lg border border-neutral-30 pl-4 pt-4 pr-4 h-full overflow-auto ">
                    <table class="table-auto w-full divide-y divide-neutral-20 text-base">
                        <thead class="divide-y divide-neutral-20">
                            <tr class="text-left text-lg font-formula1">
                                <th class="py-4">Product Name</th>
                                <th class="py-4 text-center">Total Stocks</th>
                                <th class="py-4 text-right">More Details</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-20">



                            {{-- add new product form --}}
                            <div id="addProductForm" class="hidden z-50 absolute inset-0 flex justify-center items-center">
                                <div
                                    class="max-w-[800px]  bg-default-white border border-neutral-30 rounded-lg px-4 py-5 animate-jump-in animate-duration-150 animate-ease-in">
                                    <form id="" class="" action="{{ route('product.add') }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <div class="flex justify-between gap-x-12 pb-4">
                                            <h1 id="title" class="font-formula1 text-lg">Add new product</h1>
                                            <button type="button" onclick="hideAddProductForm()">Cancel</button>
                                        </div>
                                        <div class="flex w-full h-fit">
                                            <div
                                                class="bg-primary-50 aspect-square w-[9.375rem] sm:w-[9.625rem] md:w-[10.125rem]  rounded-md flex-initial overflow-hidden">
                                                <img id="addProductImageField" class="w-full h-full" src=""
                                                    alt="">
                                                <input type="file" id="fileInput" accept="image/*"
                                                    onchange="previewImage(event)">
                                            </div>
                                            <div class="w-full flex-1 pl-4 min-w-[12]">
                                                <x-input-label for="name" class="pb-2">Name</x-input-label>
                                                <x-text-input adminDashboard="true" type="text" id="addProductNameField"
                                                    name="name" class="w-full " placeholder="Name" required />
                                                <x-input-label for="price" class="pb-2 pt-4">Price</x-input-label>
                                                <x-text-input adminDashboard="true" type="number" id="addProductPriceField"
                                                    name="price" class="w-full " placeholder="Price" required />
                                            </div>
                                        </div>
                                        <div class="flex justify-between w-full gap-2">
                                            <div class="flex-1">
                                                {{-- gender dropdown --}}
                                                <input required type="hidden" id="genderOption" name="gender"
                                                    value="">
                                                <div class="relative" id="GenderDropdownButton">
                                                    <x-input-label for="gender" class="pb-2 pt-4">Gender</x-input-label>
                                                    <div id="genderButton" onclick="toggleGenderDropdown()"
                                                        class="border-solid border-neutral-60 border-[1px] px-5 py-2 rounded-sm cursor-pointer flex justify-between">
                                                        Gender
                                                        <img id="genderUpArrow" src="/images/filter icons/Chevron Down.svg">
                                                    </div>

                                                    <!-- this is the border for the dropdown options  -->
                                                    <div id="genderDropdown"
                                                        class="rounded-md border-neutral-60 hidden bg-white">
                                                        <div
                                                            class="absolute z-10 w-full bg-default-white  border-solid border-l border-r border-b border-neutral-60 rounded-bl-sm rounded-br-sm flex flex-col">
                                                            <!-- Dropdown content -->
                                                            <x-dropdown-link id="Low to High"
                                                                onclick="setGenderOption(1, 'Unisex')">Unisex</x-dropdown-link>
                                                            <x-dropdown-link id="High to Low"
                                                                onclick="setGenderOption(2, 'Male')">Male</x-dropdown-link>
                                                            <x-dropdown-link id="Popularity"
                                                                onclick="setGenderOption(3, 'Female')">Female</x-dropdown-link>

                                                        </div>
                                                    </div>
                                                </div>
                                                <script>
                                                    function toggleGenderDropdown() {
                                                        let GenderDropdownButton = document.querySelector('#GenderDropdownButton');
                                                        let genderUpArrow = document.querySelector('#genderUpArrow');
                                                        let dropdown = document.querySelector('#genderDropdown');
                                                        dropdown.classList.toggle("hidden");
                                                        if (dropdown.classList.contains("hidden")) {
                                                            genderUpArrow.src = "/images/filter icons/Chevron Down.svg";
                                                        } else {
                                                            genderUpArrow.src = "/images/filter icons/Vector.svg";
                                                        }
                                                    }

                                                    function setGenderOption(id, name) {
                                                        let button = document.querySelector('#genderButton');
                                                        document.querySelector('#genderOption').value = id;
                                                        button.innerText = name;
                                                        toggleGenderDropdown(); // Close the dropdown after selecting an option
                                                    }

                                                    function reset() {
                                                        document.getElementById("filter").reset();
                                                        document.querySelector("#genderButton").textContent = "Options";
                                                    }

                                                    // Close dropdown when clicking outside
                                                    document.addEventListener('click', function(event) {
                                                        const GenderDropdownButton = document.getElementById('GenderDropdownButton');
                                                        const dropdown = document.getElementById('genderDropdown');
                                                        const isClickInside = GenderDropdownButton.contains(event.target);

                                                        if (!isClickInside && !dropdown.classList.contains('hidden')) {
                                                            toggleGenderDropdown();
                                                        }
                                                    });
                                                </script>
                                            </div>

                                            <div class="flex-1">
                                                {{-- category dropdown --}}
                                                <input type="hidden" id="categoryOption" name="category" value="">
                                                <div class="relative" id="categoryDropdownButton">
                                                    <x-input-label for="category" class="pb-2 pt-4">Category</x-input-label>
                                                    <div id="categoryButton" onclick="toggleCategoryDropdown()"
                                                        class="border-solid border-neutral-60 border-[1px] px-5 py-2 rounded-sm cursor-pointer flex justify-between">
                                                        Category
                                                        <img id="categoryUpArrow"
                                                            src="/images/filter icons/Chevron Down.svg">
                                                    </div>

                                                    <!-- this is the border for the dropdown options  -->
                                                    <div id="categoryDropdown" class="rounded-md border-neutral-60 hidden ">
                                                        <div
                                                            class="absolute w-full bg-default-white  border-solid border-l border-r border-b border-neutral-60 rounded-bl-sm rounded-br-sm flex flex-col">
                                                            <!-- Dropdown content -->
                                                            <x-dropdown-link id="hoodie"
                                                                onclick="setCategoryOption(1, 'Hoodie')">Hoodie</x-dropdown-link>
                                                            <x-dropdown-link id="t-shirt"
                                                                onclick="setCategoryOption(2, 'T-shirt')">T-shirt</x-dropdown-link>
                                                            <x-dropdown-link id="jacket"
                                                                onclick="setCategoryOption(3, 'Jacket')">Jacket</x-dropdown-link>
                                                            <x-dropdown-link id="trouser"
                                                                onclick="setCategoryOption(4, 'Trouser')">Trouser</x-dropdown-link>
                                                            <x-dropdown-link id="accessory"
                                                                onclick="setCategoryOption(5, 'Accessory')">Accessory</x-dropdown-link>

                                                        </div>
                                                    </div>
                                                </div>
                                                <script>
                                                    function toggleCategoryDropdown() {
                                                        let categoryDropdownButton = document.querySelector('#categoryDropdownButton');
                                                        let categoryUpArrow = document.querySelector('#categoryUpArrow');
                                                        let dropdown = document.querySelector('#categoryDropdown');
                                                        dropdown.classList.toggle("hidden");
                                                        if (dropdown.classList.contains("hidden")) {
                                                            categoryUpArrow.src = "/images/filter icons/Chevron Down.svg";
                                                        } else {
                                                            categoryUpArrow.src = "/images/filter icons/Vector.svg";
                                                        }
                                                    }

                                                    function setCategoryOption(id, name) {
                                                        let button = document.querySelector('#categoryButton');
                                                        document.querySelector('#categoryOption').value = id;
                                                        button.innerText = name;
                                                        toggleCategoryDropdown(); // Close the dropdown after selecting an option
                                                    }

                                                    function categortReset() {
                                                        document.getElementById("filter").categortReset();
                                                        document.querySelector("#button").textContent = "Options";
                                                    }

                                                    // Close dropdown when clicking outside
                                                    document.addEventListener('click', function(event) {
                                                        const categoryDropdownButton = document.getElementById('categoryDropdownButton');
                                                        const dropdown = document.getElementById('categoryDropdown');
                                                        const isClickInside = categoryDropdownButton.contains(event.target);

                                                        if (!isClickInside && !dropdown.classList.contains('hidden')) {
                                                            toggleCategoryDropdown();
                                                        }
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                        <x-input-label for="tags-input-box" class="pb-2 pt-4">Tags</x-input-label>
                                        <x-tags-input-box />
                                        <div class="flex w-full items-end gap-2">
                                            <div class="flex-1 flex flex-col justify-end">
                                                <x-input-label id="addProductStockForSLabel" for="stockForS"
                                                    class="pb-2 pt-4">Stock
                                                    For
                                                    S</x-input-label>
                                                <x-text-input adminDashboard="true" type="number"
                                                    id="addProductStockForSInput" name="stockForS" class="w-full "
                                                    placeholder="Stock For S" required />
                                            </div>

                                            <div class="flex-1 flex flex-col justify-end">
                                                <x-input-label id="addProductStockForMLabel" for="stockForM"
                                                    class="pb-2 pt-4">Stock
                                                    For
                                                    M (optional)</x-input-label>
                                                <x-text-input adminDashboard="true" type="number"
                                                    id="addProductStockForMInput" name="stockForM" class="w-full "
                                                    placeholder="Stock For M" />
                                            </div>

                                            <div class="flex-1 flex flex-col justify-end">
                                                <x-input-label id="addProductStockForLLabel" for="stockForL"
                                                    class="pb-2 pt-4">Stock
                                                    For
                                                    L (optional)</x-input-label>
                                                <x-text-input adminDashboard="true" type="number"
                                                    id="addProductStockForLInput" name="stockForL" class="w-full "
                                                    placeholder="Stock For L" />
                                            </div>
                                        </div>


                                        <x-input-label for="description" class="pb-2 pt-4 ">Description</x-input-label>
                                        <x-text-area adminDashboard="true" type="text" id="addProductDescriptionField"
                                            name="description" class="text-base lg:grow w-full h-auto "
                                            placeholder="Write your description here" required />

                                        <x-primary-button adminDashboard="true" id="addProductSaveChangesButton"
                                            type="submit" class=" w-full mt-4 bottom-0 shrink-0">Save
                                            changes</x-primary-button>
                                    </form>
                                </div>
                            </div>

                            @foreach ($products as $product)
                                <tr class="h-10">
                                    <td class="align-middle flex items-center h-10  gap-4 ">
                                        <div class="w-6 aspect-square bg-primary-50 rounded-sm overflow-hidden"><img
                                                src={{ $product->image }} alt="">
                                        </div>{{ $product->name }}
                                    </td>
                                    <td class="text-center">{{ $product->totalStock }}</td>
                                    <td class="text-right">
                                        <button class="underline"
                                            onclick="showDetails('{{ $product->image }}',  '{{ $product->name }}', {{ $product->selling_price }}, {{ $product->variations }}, '{{ $product->description }}', '{{ route('product.update', ['productId' => $product->id]) }}', '{{ route('product.delete', ['productId' => $product->id]) }}')">
                                            More details
                                        </button>
                                    </td>
                                </tr>
                            @endforeach



                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Form --}}


            {{-- second column --}}
            <div id="editDetails"
                class="z-50 overflow-hidden h-0 md:h-auto translate-y-full lg:w-0 border-none lg:translate-y-0 col-start-3 justify-self-end absolute bottom-0 left-0 border border-neutral-30 rounded-t-lg lg:rounded-lg bg-default-white w-full max-h-3/4  transition-all duration-150 ease-in-out lg:static">
                <div class=" overflow-y-auto py-4 px-5 h-full">
                    <style>
                        #editDetails::-webkit-scrollbar-thumb {
                            background-color: blue;
                            /* color of the scroll thumb */
                            border-radius: 20px;
                            /* roundness of the scroll thumb */
                            border: 999px solid orange;
                            /* creates padding around scroll thumb */
                        }

                        @media screen and (max-width: 1024px) {
                            #editDetails::-webkit-scrollbar {
                                display: none;
                            }

                            /* Hide scrollbar for IE, Edge and Firefox */
                            #editDetails {
                                -ms-overflow-style: none;
                                /* IE and Edge */
                                scrollbar-width: none;
                                /* Firefox */
                            }
                        }
                    </style>

                    {{-- Title and cancel button --}}

                    <form id="updateProductForm" class="p-0 m-0 lg:flex lg:flex-col lg:h-full" action=""
                        method="POST">
                        @csrf
                        @method('POST')

                        <div class="flex justify-between pb-4">
                            <h1 id="title" class="font-formula1 text-lg">Edit Product Details</h1>
                            <button type="button" onclick="hideForm()">Cancel</button>
                        </div>
                        {{-- image, name and price fields --}}
                        <div class="flex w-full h-fit">
                            <div
                                class="bg-primary-50 aspect-square w-[9.375rem] sm:w-[9.625rem] md:w-[10.125rem]  rounded-md flex-initial overflow-hidden">
                                <img id="imageField" class="w-full h-full" src="" alt="">
                            </div>
                            <div class="w-full flex-1 pl-4 min-w-[12]">
                                <x-input-label for="name" class="pb-2">Name</x-input-label>
                                <x-text-input adminDashboard="true" type="text" id="nameField" name="name"
                                    class="w-full " placeholder="Name" />
                                <x-input-label for="price" class="pb-2 pt-4">Price</x-input-label>
                                <x-text-input adminDashboard="true" type="number" id="priceField" name="price"
                                    class="w-full " placeholder="Price" />
                            </div>
                        </div>

                        <x-input-label id="StockForSLabel" for="stockForS" class="pb-2 pt-4">Stock For S</x-input-label>
                        <x-text-input adminDashboard="true" type="number" id="StockForSInput" name="stockForS"
                            class="w-full " placeholder="Stock For S" />

                        <x-input-label id="StockForMLabel" for="stockForM" class="pb-2 pt-4">Stock For M</x-input-label>
                        <x-text-input adminDashboard="true" type="number" id="StockForMInput" name="stockForM"
                            class="w-full " placeholder="Stock For M" />

                        <x-input-label id="StockForLLabel" for="stockForL" class="pb-2 pt-4">Stock For L</x-input-label>
                        <x-text-input adminDashboard="true" type="number" id="StockForLInput" name="stockForL"
                            class="w-full " placeholder="Stock For L" />


                        <x-input-label for="description" class="pb-2 pt-4 ">Description</x-input-label>
                        <x-text-area adminDashboard="true" type="text" id="descriptionField" name="description"
                            class="text-base lg:grow w-full h-auto " placeholder="Write your description here" required />
                        <div class="flex justify-between gap-2">
                            <x-primary-button adminDashboard="true" id="saveChangesButton" type="submit"
                                form="updateProductForm" class=" w-1/2 mt-4 bottom-0 shrink-0">Save
                                changes</x-primary-button>
                            <x-danger-button adminDashboard="true" onclick="" type="submit"
                                form="deleteProductForm" class="w-1/2 mt-4 bottom-0 shrink-0">Delete
                                Product</x-danger-button>
                        </div>
                    </form>
                    <form id="deleteProductForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                    <script>
                        function hideForm() {
                            let editDetailsForm = document.getElementById("editDetails");
                            let formOverlay = document.getElementById("formOverlay");
                            let productsTable = document.getElementById("productsTable");

                            editDetails.classList.add("translate-y-full");
                            editDetails.classList.add("lg:w-0");
                            editDetails.classList.add("border-none");
                            editDetails.classList.add("lg:translate-y-0");
                            editDetails.classList.add("col-start-3");

                            editDetails.classList.add("overflow-hidden");
                            editDetails.classList.add("h-0");
                            editDetails.classList.add("md:h-auto");




                            formOverlay.classList.add("hidden");


                            productsTable.classList.add("lg:col-span-2");
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showDetails(image, name, price, variations, description, action, action2) {

            console.log(action);
            // Show menu
            let editDetailsForm = document.getElementById("editDetails");
            let formOverlay = document.getElementById("formOverlay");
            let productsTable = document.getElementById("productsTable");

            editDetails.classList.remove("translate-y-full");
            editDetails.classList.remove("lg:w-0");
            editDetails.classList.remove("border-none");
            editDetails.classList.remove("lg:translate-y-0");
            editDetails.classList.remove("col-start-3");


            editDetails.classList.remove("overflow-hidden");
            editDetails.classList.remove("h-0");
            editDetails.classList.remove("md:h-auto");



            formOverlay.classList.remove("hidden");

            productsTable.classList.remove("lg:col-span-2");

            // Update fields
            let title = document.getElementById("title");
            let nameField = document.getElementById("nameField");
            let priceField = document.getElementById("priceField");
            let descriptionField = document.getElementById("descriptionField");
            let imageField = document.getElementById("imageField");
            let updateProductForm = document.getElementById("updateProductForm");
            let deleteProductForm = document.getElementById("deleteProductForm");

            title.innerHTML = name;
            nameField.value = name;
            priceField.value = price;
            descriptionField.value = description;
            imageField.src = image;
            updateProductForm.action = action;
            deleteProductForm.action = action2;

            // Variations S
            let StockForSLabel = document.getElementById("StockForSLabel");
            let StockForSInput = document.getElementById("StockForSInput");

            // Variations M
            let StockForMLabel = document.getElementById("StockForMLabel");
            let StockForMInput = document.getElementById("StockForMInput");

            // Variations L
            let StockForLLabel = document.getElementById("StockForLLabel");
            let StockForLInput = document.getElementById("StockForLInput");

            if (variations[0]) {
                StockForSInput.value = variations[0].stock;

                StockForMLabel.classList.add("hidden");
                StockForMInput.classList.add("hidden");

                StockForLLabel.classList.add("hidden");
                StockForLInput.classList.add("hidden");
            }

            if (variations[1]) {
                StockForMInput.value = variations[1].stock;

                StockForMLabel.classList.remove("hidden");
                StockForMInput.classList.remove("hidden");

                StockForLLabel.classList.add("hidden");
                StockForLInput.classList.add("hidden");
            }

            if (variations[2]) {
                StockForLInput.value = variations[2].stock;

                StockForMLabel.classList.remove("hidden");
                StockForMInput.classList.remove("hidden");

                StockForLLabel.classList.remove("hidden");
                StockForLInput.classList.remove("hidden");

            }



            let saveChangesButton = document.getElementById("saveChangesButton");

            // Check if any field has changed
            let fields = [nameField, priceField, descriptionField, StockForSInput, StockForMInput, StockForLInput];
            let hasChanged = fields.some(field => field.value !== field.defaultValue);

            // Show or hide save changes button based on changes
            if (hasChanged) {
                saveChangesButton.classList.remove("hidden");
            } else {
                saveChangesButton.classList.add("block");
            }







        }


        function showAddProductForm() {
            hideForm();
            let addProductForm = document.getElementById("addProductForm");
            let formOverlay = document.getElementById("formOverlay");
            addProductForm.classList.toggle("hidden");
            formOverlay.classList.toggle("hidden");
            formOverlay.classList.toggle("lg:hidden");
        }

        function hideAddProductForm() {
            let addProductForm = document.getElementById("addProductForm");
            let formOverlay = document.getElementById("formOverlay");
            addProductForm.classList.toggle("hidden");
            formOverlay.classList.toggle("hidden");
            formOverlay.classList.toggle("lg:hidden");
        }
    </script>
@endsection
