# Create image based on the official Node 6 image from the dockerhub
FROM node:6

# Create a directory where our app will be placed
RUN mkdir -p /usr/src/app/server

# Change directory so that our commands run inside this new directory
WORKDIR /usr/src/app/server

# Copy dependency definitions
COPY package.json /usr/src/app/server

# Install dependecies
RUN npm install

# Get all the code needed to run the app
COPY . /usr/src/app/server

# Expose the port the app runs in
EXPOSE 3003

# Serve the app
CMD ["npm", "start"]