# 🎨 Cafe Payroll - Design System Documentation

## Overview
A comprehensive design system with a Professional Blue/Green color palette built for the Cafe Payroll Management System.

---

## 🎯 Color Palette

### Primary Colors
- **Primary Dark**: `#0f3460` - Deep blue, used for sidebars and main navigation
- **Primary**: `#1e5a96` - Main brand color for headers and primary buttons
- **Primary Light**: `#2e7cb6` - Hover states and accents
- **Primary Lighter**: `#5ba3d0` - Light backgrounds and secondary accents

### Secondary Colors (Green Accents)
- **Success**: `#10a37f` - Action buttons, success messages, positive indicators
- **Success Light**: `#34c992` - Hover states for success actions
- **Success Lighter**: `#d1f5e8` - Light backgrounds for success alerts

### Status Colors
- **Danger**: `#d63031` - Errors, delete actions, negative indicators
- **Warning**: `#ffa500` - Warnings, pending states, caution indicators
- **Info**: `#0984e3` - Information messages
- **Disabled**: `#b2bec3` - Disabled states

### Neutral Colors
- **Dark**: `#1a1a1a` - Primary text color
- **Gray**: `#636e72` - Secondary text, muted text
- **Light Gray**: `#b2bec3` - Borders, disabled text
- **Border**: `#dfe6e9` - Input borders, dividers
- **Light**: `#f8f9fa` - Backgrounds, alternate rows
- **White**: `#ffffff` - Card backgrounds, clean surfaces

---

## 📐 Spacing System

All spacing uses CSS variables for consistency:
- `--spacing-xs`: 0.25rem (4px)
- `--spacing-sm`: 0.5rem (8px)
- `--spacing-md`: 1rem (16px)
- `--spacing-lg`: 1.5rem (24px)
- `--spacing-xl`: 2rem (32px)
- `--spacing-2xl`: 3rem (48px)
- `--spacing-3xl`: 4rem (64px)

---

## 🧩 Components

### Buttons

#### Primary Button
```html
<button class="btn btn-primary">Sign In</button>
```
- Background: Primary Blue
- Hover: Lighter blue with shadow lift effect

#### Secondary Button
```html
<button class="btn btn-secondary">Cancel</button>
```
- Background: White with blue border
- Hover: Light gray background

#### Success Button
```html
<button class="btn btn-success">Save</button>
```
- Background: Success Green
- Hover: Lighter green with shadow

#### Danger Button
```html
<button class="btn btn-danger">Delete</button>
```
- Background: Danger Red
- Hover: Slightly transparent

#### Button Sizes
- `.btn-sm` - Small buttons
- `.btn-lg` - Large buttons
- `.btn-block` - Full width button

### Forms

All form inputs include:
- Consistent padding and border radius
- Blue focus state with subtle shadow
- Accessible labels
- Error state styling

```html
<form>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="example@cafe.com">
    </div>
</form>
```

### Cards

Cards are the primary content container with:
- Clean white background
- Subtle shadow
- Smooth hover lift effect
- Colored header with gradient

```html
<div class="card">
    <div class="card-header">
        <h4>Section Title</h4>
    </div>
    <div class="card-body">
        Content goes here
    </div>
    <div class="card-footer">
        Footer content
    </div>
</div>
```

### Alerts

```html
<!-- Success Alert -->
<div class="alert alert-success">✓ Operation completed successfully</div>

<!-- Danger Alert -->
<div class="alert alert-danger">⚠ Something went wrong</div>

<!-- Warning Alert -->
<div class="alert alert-warning">⚠ Please review this</div>

<!-- Info Alert -->
<div class="alert alert-info">ℹ Information for you</div>
```

### Badges

```html
<span class="badge badge-primary">Primary</span>
<span class="badge badge-success">Active</span>
<span class="badge badge-danger">Danger</span>
<span class="badge badge-warning">Warning</span>
<span class="badge badge-light">Light</span>
```

### Tables

```html
<table class="table">
    <thead>
        <tr>
            <th>Header 1</th>
            <th>Header 2</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Data 1</td>
            <td>Data 2</td>
        </tr>
    </tbody>
</table>
```

### Status Indicators

```html
<span class="status status-active">Active</span>
<span class="status status-inactive">Inactive</span>
<span class="status status-pending">Pending</span>
<span class="status status-error">Error</span>
```

---

## 🎯 Layout Components

### Navbar
Sticky navigation bar with gradient background:
- Brand logo on the left
- Navigation links with hover states
- Active state with green bottom border

### Sidebar
Fixed left sidebar for main navigation:
- Gradient background (dark to primary blue)
- White text with hover highlights
- Active indicators with left border accent
- 250px width (hidden on mobile)

### Grid System

```html
<!-- 2 columns -->
<div class="row cols-2">
    <div>Column 1</div>
    <div>Column 2</div>
</div>

<!-- 3 columns -->
<div class="row cols-3">
    <div>Column 1</div>
    <div>Column 2</div>
    <div>Column 3</div>
</div>

<!-- 4 columns -->
<div class="row cols-4">
    <div>Column 1</div>
    <div>Column 2</div>
    <div>Column 3</div>
    <div>Column 4</div>
</div>
```

---

## 📱 Responsive Design

The system is fully responsive:
- Mobile: Single column layout, sidebar hidden
- Tablet: Adjusted spacing and grid columns
- Desktop: Full multi-column layout

```css
@media (max-width: 768px) {
    /* Mobile-specific styles */
}
```

---

## 🎨 Typography

### Font Family
Primary: `Segoe UI, Tahoma, Geneva, Verdana, sans-serif`

### Font Sizes
- `--font-size-xs`: 0.75rem (12px)
- `--font-size-sm`: 0.875rem (14px)
- `--font-size-base`: 1rem (16px)
- `--font-size-lg`: 1.125rem (18px)
- `--font-size-xl`: 1.5rem (24px)
- `--font-size-2xl`: 2rem (32px)
- `--font-size-3xl`: 2.5rem (40px)

### Font Weights
- Light: 300
- Normal: 400
- Medium: 500
- Semibold: 600
- Bold: 700

### Headings
```html
<h1>Page Title</h1>           <!-- 2.5rem, semibold -->
<h2>Section Title</h2>        <!-- 2rem, semibold -->
<h3>Subsection Title</h3>     <!-- 1.5rem, semibold -->
<h4>Minor Heading</h4>        <!-- 1.125rem, semibold -->
```

---

## 🌈 Color Usage Guide

| Element | Color | Usage |
|---------|-------|-------|
| Primary Text | Dark (#1a1a1a) | Body text, headings |
| Primary Buttons | Primary Blue (#1e5a96) | Main actions |
| Success Actions | Success Green (#10a37f) | Save, submit, complete |
| Danger Actions | Danger Red (#d63031) | Delete, error, cancel |
| Warnings | Warning Orange (#ffa500) | Caution, pending states |
| Navigation | Primary Dark (#0f3460) | Sidebar, header backgrounds |
| Cards/Containers | White (#ffffff) | Content containers |
| Backgrounds | Light Gray (#f8f9fa) | Page backgrounds |
| Borders | Border Gray (#dfe6e9) | Input borders, dividers |

---

## ✨ Special Features

### Transitions
- Fast: 150ms ease-in-out
- Base: 250ms ease-in-out
- Slow: 350ms ease-in-out

### Shadows
- Small: 0 1px 2px rgba(0, 0, 0, 0.05)
- Medium: 0 4px 6px rgba(0, 0, 0, 0.1)
- Large: 0 10px 15px rgba(0, 0, 0, 0.15)
- Extra Large: 0 20px 25px rgba(0, 0, 0, 0.2)

### Border Radius
- None: 0
- Small: 4px
- Medium: 8px
- Large: 12px
- Extra Large: 16px
- Full: 9999px (circles)

---

## 🏗️ Project Structure

```
resources/
├── css/
│   ├── design-system.css    ← Main design system
│   └── app.css
├── views/
│   ├── layouts/
│   │   └── app.blade.php    ← Main app layout
│   ├── admin/
│   │   ├── employees.blade.php
│   │   ├── payroll.blade.php
│   │   └── attendance.blade.php
│   ├── employee/
│   │   ├── my-attendance.blade.php
│   │   └── my-payroll.blade.php
│   ├── dashboard.blade.php
│   └── login.blade.php
```

---

## 🎓 Usage Examples

### Dashboard Cards
```html
<div class="card">
    <div class="card-body">
        <h3 style="color: var(--color-primary);">Total Employees</h3>
        <p style="color: var(--color-gray);">125 active employees</p>
    </div>
</div>
```

### Status Badge
```html
<span class="badge badge-success">Active</span>
<span class="badge badge-warning">Pending</span>
<span class="badge badge-danger">Inactive</span>
```

### Form Input
```html
<div class="form-group">
    <label for="salary">Monthly Salary</label>
    <input type="number" id="salary" name="salary" placeholder="Enter salary">
</div>
```

### Data Table
```html
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Position</th>
            <th>Salary</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>John Doe</td>
            <td>Barista</td>
            <td>₱15,000</td>
        </tr>
    </tbody>
</table>
```

---

## 📝 Customization

To customize the design system, modify the CSS variables in `design-system.css`:

```css
:root {
  --color-primary: #1e5a96;        /* Change primary blue */
  --color-success: #10a37f;        /* Change success green */
  --font-size-base: 1rem;          /* Change base font size */
  --spacing-md: 1rem;              /* Change spacing unit */
}
```

All components automatically use these variables, so changes propagate throughout the system.

---

## 🚀 Best Practices

1. **Always use design system variables** - Don't hardcode colors
2. **Use semantic colors** - Use `btn-danger` for destructive actions
3. **Maintain consistency** - Follow the established patterns
4. **Test responsively** - Check mobile, tablet, and desktop views
5. **Use cards for grouping** - Keep content organized with cards
6. **Provide visual feedback** - Use badges and status indicators
7. **Ensure accessibility** - Use proper contrast ratios and semantic HTML

---

## 🎯 Implementation Status

✅ Design System CSS
✅ Main Layout Template
✅ Login Page
✅ Dashboard
✅ Employee Management
✅ Payroll Management  
✅ Attendance Tracking
✅ Employee Views

---

*Last Updated: June 1, 2026*
*Cafe Payroll Management System v1.0*
