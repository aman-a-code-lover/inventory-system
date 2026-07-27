<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

import {
    BookOpen,
    FolderGit2,
    LayoutGrid,
    Tag,
    Boxes,
    Ruler,
    Package,
    ShoppingCart,
} from '@lucide/vue';

import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';

import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';

import { dashboard } from '@/routes';

import { index as brandsIndex } from '@/routes/brands';
import { index as categoriesIndex } from '@/routes/categories';
import { index as unitsIndex } from '@/routes/units';
import { index as productsIndex } from '@/routes/products';
import { index as supplierIndex } from '@/routes/suppliers';
import { index as customersIndex } from '@/routes/customers';
import { index as purchaseIndex } from '@/routes/purchases';
import { index as salesIndex } from '@/routes/sales';
import { index as inventoryBalancesIndex } from '@/routes/inventory-balances';
import { index as stockAdjustmentsIndex } from '@/routes/stock-adjustments';
import { index as stockMovementsIndex } from '@/routes/stock-movements';

import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },

    {
        title: 'Categories',
        href: categoriesIndex(),
        icon: Tag,
    },

    {
        title: 'Brands',
        href: brandsIndex(),
        icon: Boxes,
    },

    {
        title: 'Units',
        href: unitsIndex(),
        icon: Ruler,
    },

    {
        title: 'Products',
        href: productsIndex(),
        icon: Package,
    },

    {
        title: 'Suppliers',
        href: supplierIndex(),
        icon: Package,
    },

    {
        title: 'Customers',
        href: customersIndex(),
        icon: Package,
    },

    {
        title: 'Purchases',
        href: purchaseIndex(),
        icon: ShoppingCart,
    },

    {
        title: 'Sales',
        href: salesIndex(),
        icon: ShoppingCart,
    },

    {
        title: 'Inventory Balances',
        href: inventoryBalancesIndex(),
        icon: Package,
    },

    {
        title: 'Stock Adjustments',
        href: stockAdjustmentsIndex(),
        icon: Package,
    },

    {
        title: 'Stock Movements',
        href: stockMovementsIndex(),
        icon: Package,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: FolderGit2,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
