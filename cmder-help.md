| Lable | Command | Description |
| ---- | ---- | ---- |
| echo:env | echo JAVA_HOME:${env:JAVA_HOME}, USERPROFILE:${env:USERPROFILE} |  |
| echo:test | echo ${input:param1}, ${input:log_file}, ${select:LOGLEVEL} |  |
| node:version | node -v |  |
| node:hello-world | echo console.log('hello world'); >> ./hello-world.js |  |
| node:run | node ${file} |  |
| java:version | java -version |  |
| ruby:version | ruby -v |  |
| python:version | python --version |  |
| php:version | php -v |  |
| laravel:serve | php artisan serve |  |