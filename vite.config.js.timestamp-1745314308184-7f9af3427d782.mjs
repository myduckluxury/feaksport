// vite.config.js
import { defineConfig } from "file:///C:/laragon/www/W40-DATN/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/laragon/www/W40-DATN/node_modules/laravel-vite-plugin/dist/index.js";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/css/app.css",
        "resources/js/app.js",
        "resources/js/product/list.js",
        "resources/js/product/detail.js",
        "resources/js/product-variant.js",
        "resources/js/category.js",
        "resources/js/brand.js",
        "resources/js/order/status.js",
        "resources/js/order/request.js",
        "resources/js/voucher.js",
        "resources/js/user.js"
      ],
      refresh: true
    })
  ]
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxsYXJhZ29uXFxcXHd3d1xcXFxXNDAtREFUTlwiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9maWxlbmFtZSA9IFwiQzpcXFxcbGFyYWdvblxcXFx3d3dcXFxcVzQwLURBVE5cXFxcdml0ZS5jb25maWcuanNcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfaW1wb3J0X21ldGFfdXJsID0gXCJmaWxlOi8vL0M6L2xhcmFnb24vd3d3L1c0MC1EQVROL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcblxuZXhwb3J0IGRlZmF1bHQgZGVmaW5lQ29uZmlnKHtcbiAgICBwbHVnaW5zOiBbXG4gICAgICAgIGxhcmF2ZWwoe1xuICAgICAgICAgICAgaW5wdXQ6IFtcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Nzcy9hcHAuY3NzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL2FwcC5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9qcy9wcm9kdWN0L2xpc3QuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvanMvcHJvZHVjdC9kZXRhaWwuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvanMvcHJvZHVjdC12YXJpYW50LmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL2NhdGVnb3J5LmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL2JyYW5kLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL29yZGVyL3N0YXR1cy5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9qcy9vcmRlci9yZXF1ZXN0LmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL3ZvdWNoZXIuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvanMvdXNlci5qcydcbiAgICAgICAgICAgIF0sXG4gICAgICAgICAgICByZWZyZXNoOiB0cnVlLFxuICAgICAgICB9KSxcbiAgICBdLFxufSk7XG4iXSwKICAibWFwcGluZ3MiOiAiO0FBQStQLFNBQVMsb0JBQW9CO0FBQzVSLE9BQU8sYUFBYTtBQUVwQixJQUFPLHNCQUFRLGFBQWE7QUFBQSxFQUN4QixTQUFTO0FBQUEsSUFDTCxRQUFRO0FBQUEsTUFDSixPQUFPO0FBQUEsUUFDSDtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxNQUNKO0FBQUEsTUFDQSxTQUFTO0FBQUEsSUFDYixDQUFDO0FBQUEsRUFDTDtBQUNKLENBQUM7IiwKICAibmFtZXMiOiBbXQp9Cg==
