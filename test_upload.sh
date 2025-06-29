#!/bin/bash

# Test script for file upload endpoint
# Replace YOUR_TOKEN with actual bearer token

TOKEN="YOUR_TOKEN"
URL="http://localhost:8000/api/applicant/profile/complete_profile"

echo "Testing file upload endpoint..."

# Create a test PDF file
echo "Creating test PDF file..."
echo "%PDF-1.4" > test_cv.pdf
echo "Test CV content" >> test_cv.pdf

# Test with minimal data
curl -X PUT \
  "$URL" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: multipart/form-data" \
  -F "bio=Test bio from curl" \
  -F "file_cv=@test_cv.pdf" \
  -v

echo ""
echo "Test completed. Check the Laravel logs for debug information."
echo "Cleaning up test file..."
rm test_cv.pdf 