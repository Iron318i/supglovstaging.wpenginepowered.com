let sgSubscribers = {}

function sgSubscribe(eventName, callback) {
  if (sgSubscribers[eventName] === undefined) {
    sgSubscribers[eventName] = []
  }

  sgSubscribers[eventName] = [...sgSubscribers[eventName], callback];

  return function sgUnsubscribe() {
    sgSubscribers[eventName] = sgSubscribers[eventName].filter((cb) => {
      return cb !== callback
    });
  }
};

function sgPublish(eventName, data) {
  if (sgSubscribers[eventName]) {
    sgSubscribers[eventName].forEach((callback) => {
      callback(data)
    })
  }
}