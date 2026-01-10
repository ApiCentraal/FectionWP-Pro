# 🚀 Push Tag v1.1.5 to Trigger Release

## Quick Instructions

Run these commands in your local repository to trigger the automated release:

```bash
# 1. Fetch the latest changes (includes the local tag)
git fetch origin copilot/add-release-tag-v115

# 2. Checkout the branch
git checkout copilot/add-release-tag-v115

# 3. Pull latest changes
git pull origin copilot/add-release-tag-v115

# 4. Create the tag (if not already present)
git tag -a v1.1.5 -m "Release version 1.1.5 - Page builder integrations"

# 5. Push the tag to trigger release workflow
git push origin v1.1.5
```

## What Happens Next

### Immediate (< 1 minute)
- ✅ GitHub receives tag push
- ✅ Release workflow triggers automatically
- ✅ You can watch at: https://github.com/ApiCentraal/FectionWP-Pro/actions

### During Workflow (2-3 minutes)
- ✅ Workflow extracts version from tag (v1.1.5 → 1.1.5)
- ✅ Verifies version matches package.json: ✓ (both are 1.1.5)
- ✅ Extracts changelog from CHANGELOG.md
- ✅ Creates distribution package: `fectionwp-pro-1.1.5.zip`
- ✅ Verifies package contents (no .git, node_modules, etc.)
- ✅ Creates GitHub Release with zip attachment

### After Workflow Completes
- ✅ Release appears at: https://github.com/ApiCentraal/FectionWP-Pro/releases/tag/v1.1.5
- ✅ Zip file available for download
- ✅ Release notes populated from CHANGELOG.md

## Verification Steps

### 1. Check Workflow Status
Visit: https://github.com/ApiCentraal/FectionWP-Pro/actions

Look for:
- ✅ Green checkmark (success)
- ✅ "Release" workflow
- ✅ Triggered by "push" on tag v1.1.5

### 2. Verify Release
Visit: https://github.com/ApiCentraal/FectionWP-Pro/releases

Check:
- ✅ Release title: "FectionWP Pro 1.1.5"
- ✅ Tag: v1.1.5
- ✅ Asset: fectionwp-pro-1.1.5.zip
- ✅ Release notes contain changelog content

### 3. Test Download
```bash
# Download the release package
wget https://github.com/ApiCentraal/FectionWP-Pro/releases/download/v1.1.5/fectionwp-pro-1.1.5.zip

# Extract and verify
unzip fectionwp-pro-1.1.5.zip
cd fectionwp-pro

# Check version in style.css
grep "Version:" style.css
# Should show: Version: 1.1.5

# Verify key files exist
ls -la | grep -E "(functions.php|style.css|screenshot.png)"

# Verify excluded files are NOT present
ls -la | grep -E "(node_modules|.git|composer.json)" && echo "ERROR: Excluded files found!" || echo "✓ Clean package"

### (Optioneel) Child theme asset
Als de release ook de child theme bevat, download en test dan ook:
```bash
wget https://github.com/ApiCentraal/FectionWP-Pro/releases/download/v1.1.5/fectionwp-pro-tffp-1.1.6.zip
unzip fectionwp-pro-tffp-1.1.6.zip
ls -la fectionwp-pro-tffp/ | head
grep "^Template:" fectionwp-pro-tffp/style.css
```
```

## Expected Release Content

### Release Notes (from CHANGELOG.md)

```
### Added
- Complete integration with 7+ popular page builders
  (Elementor, Divi, Beaver Builder, WPBakery, Oxygen, Brizy, Thrive Architect)
- Automatic page builder detection and compatibility hooks
- Theme color and font synchronization with page builders
- Bootstrap grid compatibility layer for page builders
- Full-width template support for all integrated builders
- CSS compatibility fixes for each builder
- Comprehensive documentation in PAGE_BUILDER_INTEGRATION.md

### Changed
- Enhanced Gutenberg integration with Bootstrap color palette
```

### Package Contents
- WordPress theme files (PHP, CSS, JS)
- Assets (images, fonts, stylesheets)
- Template files and parts
- Child theme scaffold
- README.md (documentation)
- **Excludes:** .git, .github, node_modules, vendor, *.md (except README.md)

## Troubleshooting

### Error: "Repository rule violations"
If you see this error when pushing the tag:
```
remote: error: GH013: Repository rule violations found for refs/tags/v1.1.5.
```

**Solution:** You need admin/maintain permissions. Check with repository owner or:
- Visit: https://github.com/ApiCentraal/FectionWP-Pro/settings/rules
- Contact repository administrator
- Use GitHub account with appropriate permissions

### Error: "Tag already exists"
If tag already exists and you need to re-create it:
```bash
# Delete local tag
git tag -d v1.1.5

# Delete remote tag (if pushed)
git push origin :refs/tags/v1.1.5

# Re-create tag
git tag -a v1.1.5 -m "Release version 1.1.5 - Page builder integrations"

# Push tag
git push origin v1.1.5
```

### Workflow Fails
1. Check workflow logs: Actions → Release workflow → Latest run
2. Review error messages
3. Common issues:
   - Version mismatch (verify package.json matches tag)
   - Missing CHANGELOG.md section
   - rsync/zip command errors
4. Fix issues and re-push tag (see "Tag already exists" above)

### No Release Created
If workflow succeeds but no release appears:
- Check permissions: Workflow needs `contents: write` permission
- Verify: `.github/workflows/release.yml` has `permissions: contents: write`
- Check: Repository Settings → Actions → General → Workflow permissions

## Timeline

**Before Tag Push:**
- [x] Version 1.1.5 in style.css ✓
- [x] Version 1.1.5 in package.json ✓
- [x] CHANGELOG.md updated ✓
- [x] Release workflow exists ✓
- [x] Tag created locally ✓

**After Tag Push:**
- [ ] Tag pushed to GitHub
- [ ] Workflow triggered
- [ ] Package built
- [ ] Release created
- [ ] Zip file attached

## Support

**Documentation:**
- Full release process: `RELEASE.md`
- Release status: `RELEASE_STATUS_v1.1.5.md`
- Workflow file: `.github/workflows/release.yml`

**Links:**
- Actions: https://github.com/ApiCentraal/FectionWP-Pro/actions
- Releases: https://github.com/ApiCentraal/FectionWP-Pro/releases
- Rules: https://github.com/ApiCentraal/FectionWP-Pro/rules

---

**Ready to proceed:** All prerequisites complete. Push the tag to trigger release! 🚀
