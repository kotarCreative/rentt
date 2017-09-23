<template>
    <div id="main-header">
        <div class="logo-wrapper">
            <img src="/imgs/main-logo.png" />
        </div>
        <ul class="creation-nav">
            <li class="nav-item">
                <button @click="changeSection('info')">Basic Info</button>
            </li>
            <li class="nav-item">
                <button @click="changeSection('address')">Address</button>
            </li>
            <li class="nav-item">
                <button @click="changeSection('Details')">Details</button>
            </li>
            <li class="nav-item">
                <button @click="changeSection('Photos')">Photos</button>
            </li>
            <li class="nav-item">
                <button @click="changeSection('Description')">Description</button>
            </li>
        </ul>
    </div>
</template>
