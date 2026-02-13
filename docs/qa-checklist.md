# CarlasHub QA Checklist

## Keyboard Navigation
- [ ] All interactive elements reachable by Tab.
- [ ] Focus outline is clearly visible on buttons, links, and inputs.
- [ ] Navigation menu can be toggled and used without a mouse.

## Focus Visibility
- [ ] Focus outline meets 3:1 contrast against adjacent colors.
- [ ] Focus state is not removed by custom styles.

## Contrast (WCAG AA)
- [ ] Body text meets 4.5:1 contrast.
- [ ] Headings meet 3:1 contrast.
- [ ] Buttons meet 4.5:1 contrast.

## Headings and Landmarks
- [ ] Single H1 per page.
- [ ] Logical heading order (H2 > H3 > H4).
- [ ] Header, main, and footer landmarks present.

## Forms
- [ ] Inputs have visible labels or accessible names.
- [ ] Placeholder text is not the only label.
- [ ] Error states are visible and descriptive.

## Responsive Layouts
- [ ] No horizontal scroll at 320px.
- [ ] Columns stack correctly on mobile.
- [ ] Images scale within containers.

## Performance Sanity
- [ ] Theme CSS under 200KB.
- [ ] Fonts load with `display=swap`.
- [ ] No layout shifts in hero and cards.

## Notes / Fixes
- [ ] Document issues found and fix before completion.
