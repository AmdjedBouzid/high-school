const Loader = () => {
  return (
    <div className="flex justify-center items-center h-full">
      <div
        className="animate-spin rounded-full h-6 w-6 border-4 
                     border-gray-300 dark:border-gray-600 
                     border-t-white dark:border-t-gray-100"
      />
    </div>
  );
};

export default Loader;
